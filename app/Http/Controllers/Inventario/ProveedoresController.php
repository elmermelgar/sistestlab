<?php

namespace App\Http\Controllers\Inventario;
use App\Activo;
use Illuminate\Http\Request;
use App\Proveedor;
use Laracasts\Flash;
use App\Http\Controllers\Controller;
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
        return view('Inventario.Proveedores.proveedores_index',  array('proveedores'=>$proveedores, 'activos'=>$activos, 'valor'=>$valor));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Inventario.Proveedores.proveedores_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = new Proveedor($request->all());
        $proveedor->save();
        Notify::success('Proveedor "'.$proveedor->nombre.'" creado correctamente', 'Exito!!');
        return redirect()->route('proveedores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view('Inventario.Proveedores.proveedores_edit')->with('proveedor',$proveedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->fill($request->all());
//        $proveedor->nombre = $request->nombre;
//        $proveedor->telefono = $request->telefono;
//        $proveedor->rubro = $request->rubro;
//        $proveedor->email = $request->email;
//        $proveedor->ubicacion = $request->ubicacion;
//        $proveedor->otros = $request->otros;
        $proveedor->save();
        Notify::warning('El Proveedor '.$proveedor->nombre.' ha sido actualizado correctamente', 'Actualización');
        return redirect()->route('proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);
        $activo = Activo::where(array('proveedor_id' => $id))->first();
        if($activo){
            Notify::danger('El proveedor "'.$proveedor->nombre.'"" no puede ser eliminado porque posee registros asociados', 'Error!!');
            return redirect()->route('proveedores.index');
        }else{
            $proveedor->delete();

            Notify::warning('Proveedor '.$proveedor->nombre.' eliminado correctamente', 'Eliminación!!');
            return redirect()->route('proveedores.index');
        }
    }
}
