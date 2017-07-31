<?php

namespace App\Http\Controllers\Inventario;

use App\Activo;
use App\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        $activos = Activo::all();
        $valor = false;
        return view('inventario.proveedores.index', [
            'proveedores' => $proveedores, 'activos' => $activos, 'valor' => $valor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.proveedores.edit', ['proveedor' => null]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view('inventario.proveedores.edit')->with('proveedor', $proveedor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['telefono' => str_replace('-', '', $request->telefono)]);
        $proveedor = Proveedor::create($request->all());
        Notify::success('Proveedor "' . $proveedor->nombre . '" creado correctamente', 'Exito!!');
        return redirect()->route('proveedores.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge(['telefono' => str_replace('-', '', $request->telefono)]);
        $proveedor = Proveedor::find($id);
        $proveedor->update($request->all());
        Notify::warning('El Proveedor ' . $proveedor->nombre . ' ha sido actualizado correctamente', 'Actualización');
        return redirect()->route('proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);
        $activo = Activo::where(array('proveedor_id' => $id))->first();
        if ($activo) {
            Notify::danger('El proveedor "' . $proveedor->nombre . '" no puede ser eliminado porque posee registros asociados', 'Error!!');
            return redirect()->route('proveedores.index');
        } else {
            $proveedor->delete();

            Notify::warning('Proveedor ' . $proveedor->nombre . ' eliminado correctamente', 'Eliminación!!');
            return redirect()->route('proveedores.index');
        }
    }
}
