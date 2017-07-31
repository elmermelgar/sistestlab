<?php

namespace App\Http\Controllers\Inventario;

use App\Activo;
use App\Estado;
use App\Existencia;
use App\Inventario;
use App\Proveedor;
use App\Sucursal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;
use Carbon\Carbon;

class ActivoController extends Controller
{
    /**
     * ActivoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista de activos registrados.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $activos = Activo::all();
        return view('inventario.activo.index')->with('activos', $activos);
    }

    /**
     * Muestra el detalle del activo con su respectivo inventario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activo = Activo::find($id);
        $sucursales = Sucursal::whereIn('id', $activo->inventarios()
            ->pluck('sucursal_id')->all())->get();
        $existencias = Existencia::where('activo_id', $activo->id)->get()->groupBy('sucursal_id');
        return view('inventario.activo.show', [
            'sucursales' => $sucursales,
            'activo' => $activo,
            'existencias' => $existencias
        ]);
    }

    /**
     * Muestra el formulario de creacion de un nuevo recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $estado = Estado::all();
        $sucursales = Sucursal::all();
        return view('inventario.activo.edit', [
            'activo' => null,
            'proveedores' => $proveedores,
            'estados' => $estado,
            'sucursales' => $sucursales,
        ]);
    }

    /**
     * Muestra el formulario de edicion del activo.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activo = Activo::find($id);
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        $estados = Estado::all();
        return view('inventario.activo.edit', [
            'activo' => $activo,
            'proveedores' => $proveedores,
            'estados' => $estados,
            'sucursales' => $sucursales,
        ]);
    }

    /**
     * Actualiza el activo especificado.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $activo = Activo::find($id);
        $activo->update($request->all());
        Notify::warning('activo ' . $activo->nombre . ' se actualizó correctamente', 'Actualización');
        return redirect()->route('activo.show', [$activo->id]);
    }

    /**
     * Elimina un activo especificado.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activo = Activo::find($id);
        $inventario = Inventario::where(['activo_id' => $id])->first();
        if ($inventario) {
            Notify::danger('El activo "' . $activo->nombre_activo . '" no puede ser eliminado porque posee registro asociado', 'Error!!');
        } else {
            $activo->delete();
            Notify::warning('El activo "' . $activo->nombre_activo . '" ha sido eliminado correctamente', 'Eliminación');
        }
        return redirect()->route('activo.index');
    }

    /**
     * Metodo de guardado de activo he inventario.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activo = Activo::create($request->all());
        Notify::success("Activo $activo->nombre_activo registrado correctamente", 'Exito!!');
        return redirect()->route('activo.index');
    }

}
