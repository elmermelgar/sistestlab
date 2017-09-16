<?php

namespace App\Http\Controllers;

use App\Bono;
use App\Estado;
use App\Factura;
use App\Recolector;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jleon\LaravelPnotify\Notify;

class RecolectorController extends Controller
{

    /**
     * RecolectorController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de recolectores
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('recolector.index', ['recolectores' => Recolector::all()]);
    }

    /**
     * Muestra los detalles del recolector especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($recolector = Recolector::find($id)) {
            $mes = Carbon::now()->startOfMonth()->toDateString();
            $estado_ids = Estado::whereIn('name', [Factura::BORRADOR, Factura::ANULADA])
                ->where('tipo', 'factura')->pluck('id');
            //recolecciones que no han sido anuladas o son borradores
            $recolecciones = Factura::where('recolector_id', $recolector->id)
                ->whereNotIn('estado_id', $estado_ids)
                ->whereDate('date', Carbon::now()->toDateString())->get();
            $bonos_aplicados = $recolector->bonos()->where('date', '>=', $mes)->get();
            setlocale(LC_TIME, 'es_SV.UTF-8', 'es');
            return view('recolector.show', [
                'recolector' => $recolector,
                'recolecciones' => $recolecciones,
                'bonos_aplicados' => $bonos_aplicados,
                'bonos' => Bono::all(),
            ]);
        }
        return abort(404);
    }

    /**
     * Muestra el formulario para registrar un recolector
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('recolector.edit', ['recolector' => null]);
    }

    /**
     * Muestra el formulario para editar un recolector
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($recolector = Recolector::find($id)) {
            return view('recolector.edit', ['recolector' => $recolector]);
        }
        return abort(404);
    }

    /**
     * Registra a un recolector
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->merge(['dui' => str_replace('-', '', $request->dui)]);
        $request->merge(['nit' => str_replace('-', '', $request->nit)]);
        if ($request->id && $recolector = Recolector::find($request->id)) {
            $recolector->update($request->all());
        } else {
            $recolector = Recolector::create($request->all());
        }
        Notify::success('Recolector registrado correctamente');
        return redirect()->action('RecolectorController@show', ['id' => $recolector->id]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function bonificar($id, Request $request)
    {
        if ($id != $request->id || !$recolector = Recolector::find($request->id)) {
            Notify::danger('No se aplicó el bono');
            return back()->withInput();
        }
        try {
            $bono = Bono::find($request->bono_id);
            $recolector->bonos()->attach([$bono->id => [
                'sucursal_id' => Auth::user()->account->sucursal->id,
                'amount' => -$bono->monto,
                'type' => Transaction::CASH,
            ]]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23505) {
                Notify::danger('Ya se aplicó un bono con ese monto este día');
            }
            return back()->withInput();
        }

        Notify::success('El bono se aplicó correctamente');
        return redirect()->action('RecolectorController@show', ['id' => $recolector->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desactivar(Request $request)
    {
        if ($request->recolector_id && $recolector = Recolector::find($request->recolector_id)) {
            $recolector->activo = false;
            $recolector->save();
            Notify::warning('El recolector se marco como inactivo');
        } else {
            Notify::danger('No se desactivo al recolector');
            return back();
        }
        return redirect()->action('RecolectorController@show', ['id' => $recolector->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activar(Request $request)
    {
        if ($request->recolector_id && $recolector = Recolector::find($request->recolector_id)) {
            $recolector->activo = true;
            $recolector->save();
            Notify::success('El recolector fue activado correctamente');
        } else {
            Notify::danger('No se activo al recolector');
            return back();
        }
        return redirect()->action('RecolectorController@show', ['id' => $recolector->id]);

    }

}
