<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Http\Controllers\Controller;
use App\Activo;
use App\Inventario;
use App\Estado;
use App\Sucursal;
use Carbon\Carbon;
use Jleon\LaravelPnotify\Notify;

class ActivoController extends Controller
{
    /**
     * Lista de activos registrados.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $activos = Activo::all();
        return view('inventario.activo.activo_index')->with('activos', $activos);
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
        $inventario = Inventario::where(['activo_id' => $id])->first();
        Carbon::setLocale('es');
        $carga = Carbon::parse($inventario->fecha_cargado)->format('l j \\of F Y ');

        if ($inventario->fecha_vencimiento) {

            $vence = Carbon::parse($inventario->fecha_vencimiento)->format('l j \\of F Y ');
            $today = Carbon::today();
            $venimiento = Carbon::createFromFormat('Y-m-d', $inventario->fecha_vencimiento)->subMonth();

            if ($venimiento <= $today) {
                Notify::error('Reactivo "' . $inventario->activo->nombre_activo . '" próximo a vencerse', 'Próximo a vencerse');
            }
        } else {
            $vence = 'No existe ninguna fecha de vencimiento';
        }
//        dd(Carbon::createFromFormat('Y-m-d',$inventario->fecha_vencimiento));
        return view('inventario.activo.inventario_show', [
            'activo' => $activo, 'inventario' => $inventario, 'carga' => $carga, 'vence' => $vence
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
        return view('inventario.activo.activo_edit', [
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
        return view('inventario.activo.activo_edit', [
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
        Notify::warning('activo ' . $activo->nombre_activo . ' se actualizó correctamente', 'Actualización');
        return redirect()->route('activo.index');
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
            return redirect()->route('activo.index');
        } else {
            $activo->delete();
            Notify::warning('El activo "' . $activo->nombre_activo . '" ha sido eliminado correctamente', 'Eliminación');
            return redirect()->route('activo.index');
        }
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
