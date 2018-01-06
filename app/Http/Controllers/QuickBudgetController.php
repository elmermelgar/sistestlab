<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class QuickBudgetController extends Controller
{
    /**
     * QuickBudgetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $params = $request->all();

        if (($validator = $this->validation($params))->fails()) {
            return redirect()->route('presupuesto_rapido.edit')
                ->withErrors($validator)->withInput();
        }

        if (count($params['cantidades']) != count($params['perfiles'])) {
            Notify::danger('Parámetros incorrectos!');
            return redirect()->route('presupuesto_rapido.edit');
        }

        $data = $this->getData($params);

        return view('presupuesto_rapido.show', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $params = $request->all();
        $validator = \Validator::make($request->all(), [
            'cliente' => 'nullable|string',
            'cantidades' => 'nullable|array',
            'perfiles' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->route('presupuesto_rapido.edit')
                ->withErrors($validator)->withInput();
        }

        if ($params && count($params['cantidades']) != count($params['perfiles'])) {
            Notify::danger('Parámetros incorrectos!');
            dump($params);
            return redirect()->route('presupuesto_rapido.edit');
        }

        $sucursal = \Auth::user()->account->sucursal;
        $perfiles = \App\Profile::select(['id', 'name', 'display_name', 'type', 'description', 'price'])
            ->where('sucursal_id', $sucursal->id)->where('enabled', true)
            ->join('profile_sucursal', 'profiles.id', '=', 'profile_sucursal.profile_id')
            ->get();
        $image_path = url('storage/images/' . \App\Imagen::getDefaultImage()->file_name);

        return view('presupuesto_rapido.edit', [
            'sucursal' => $sucursal,
            'perfiles' => $perfiles,
            'cajero' => \Auth::user()->account,
            'image' => $image_path,
            'params' => $this->returnParams($request),
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function pdf(Request $request)
    {
        /*
        if (!$params = $this->jsonParams($request)) {
            Notify::danger('Parámetros incorrectos!');
            return redirect('presupuesto_rapido.edit');
        }
        */

        $params = $request->all();

        if (($validator = $this->validation($params))->fails()) {
            return redirect()->route('presupuesto_rapido.edit')
                ->withErrors($validator)->withInput();
        }

        if (count($params['cantidades']) != count($params['perfiles'])) {
            Notify::danger('Parámetros incorrectos!');
            return redirect()->route('presupuesto_rapido.edit');
        }

        $data = $this->getData($params, true);

//        return view('presupuesto_rapido.pdf', $data);
//        $pdf = \App::make('dompdf.wrapper');
        $pdf = \PDF::loadView('presupuesto_rapido.pdf', $data)->setPaper('letter');
        $pdf->getDomPDF()->getCanvas()->get_CPDF()->openHere('XYZ', null, null, 0.5);
        return $pdf->stream('presupuesto_rapido_' . \Carbon\Carbon::now()->format('YmdHi') . '.pdf');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function jsonParams(Request $request)
    {
        $params = json_decode($request->params, true);
        return $params;
    }

    /**
     * @param array $params
     * @return mixed
     */
    private function validation($params)
    {
        return \Validator::make($params, [
            'cliente' => 'nullable|string',
            'cantidades' => 'required|array',
            'perfiles' => 'required|array'
        ]);
    }

    /**
     * @param $params
     * @param bool $pdf
     * @return array
     */
    private function getData($params, $pdf = false)
    {
        $sucursal = \Auth::user()->account->sucursal;
        $perfiles = \App\Profile::select(['profiles.name', 'profiles.display_name', 'profile_sucursal.price'])
            ->join('profile_sucursal', 'profiles.id', '=', 'profile_sucursal.profile_id')
            ->whereIn('profiles.id', $params['perfiles'])
            ->where('profile_sucursal.sucursal_id', $sucursal->id)
            ->get();

        $data = [
            'sucursal' => $sucursal,
            'cliente' => $params['cliente'],
            'cajero' => \Auth::user()->account,
            'perfiles' => $perfiles,
            'cantidades' => $params['cantidades'],
            'nivel' => 0.00,
            'total' => 0.00,
        ];
        $image_path = 'storage/images/' . \App\Imagen::getDefaultImage()->file_name;
        $pdf ? $data['image'] = $image_path :
            $data['image'] = url($image_path);

        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function returnParams(Request $request)
    {
        $params = [];
        $params['cliente'] = $request->cliente ?: null;
        $params['perfiles'] = $request->perfiles ?: [];
        $params['cantidades'] = $request->cantidades ?: [];
        return $params;
    }

}
