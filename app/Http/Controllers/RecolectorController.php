<?php

namespace App\Http\Controllers;

use App\Bono;
use App\Recolector;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            $bonos_aplicados = $recolector->bonos()->where('fecha', '>=', $mes)->get();
            return view('recolector.show', [
                'recolector' => $recolector,
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

    public function bonoficar($id, Request $request)
    {
        if ($id != $request->id || !$recolector = Recolector::find($request->id)) {
            Notify::danger('No se aplicó el bono');
            return back()->withInput();
        }
        try {
            $bono = Bono::find($request->bono_id);
            $recolector->bonos()->attach([$bono->id => ['fecha' => Carbon::now()->toDateString()]]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23505) {
                Notify::danger('Ya se aplicó un bono con ese monto este día');
            }
            return back()->withInput();
        }

        Notify::success('El bono se aplicó correctamente');
        return redirect()->action('RecolectorController@show', ['id' => $recolector->id]);
    }

}
