<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Http\Controllers\Controller;
use App\Activo;
use App\Inventario;
use App\Estado;
use App\Sucursal;
use \DateTime;
use Carbon\Carbon;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activos = Activo::all();
        return view('Inventario.Activo.activo_index')->with('activos',$activos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $estado = Estado::all();
        $sucursal = Sucursal::all();
        return view('Inventario.Activo.activo_create', array('proveedores'=>$proveedores, 'estados'=>$estado,'sucursales'=>$sucursal));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activo = new Activo($request->all());
        $fechaadq = DateTime::createFromFormat('d/m/Y', $request->fecha_adq);
        $activo->fecha_adq = $fechaadq;
        $activo->cod_inventario = $activo->id.$request->fecha_adq;
//        $activo->fecha_adq = $fechaadq;
        $activo->save();
        $activo->cod_inventario = $activo->id.$request->fecha_adq;
        $activo->save();
        $inventario = new Inventario();
        $inventario->cod_inventario = $activo->cod_inventario;
        $inventario->activo_id = $activo->id;
        $inventario->existencia = $request->existencia;
        $inventario->cantidad_minima = $request->cantidad_minima;
        $inventario->cantidad_maxima = $request->cantidad_maxima;
        if($request->fecha_vencimiento==''){

        }else{
            $inventario->fecha_vencimiento = DateTime::createFromFormat('d/m/Y', $request->fecha_vencimiento);
        }
        $inventario->fecha_cargado = $today = Carbon::today();
        $inventario->save();
        flash('Activo '.$activo->nombre_activo.'Creado Correctamente', 'success');
        return redirect()->route('activo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activo = Activo::find($id);
        $inventario = Inventario::where(array('activo_id' => $id))->first();
        return view('Inventario.Activo.activo_show', array('activo'=>$activo, 'inventario'=>$inventario));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activo = Activo::find($id);
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        $estados = Estado::all();
        return view('Inventario.Activo.activo_edit', array('activo'=>$activo, 'proveedores'=>$proveedores, 'sucursales'=>$sucursales, 'estados'=>$estados));
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
        $activo = Activo::find($id);
        $activo->fill($request->all());
        $activo->save();

        flash('El Activo "'.$activo->nombre_activo.'" ha sido actualizado correctamente', 'warning');
        return redirect()->route('activo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activo = Activo::find($id);
        $activo->delete();

        flash('El Activo "'.$activo->nombre_activo.'" ha sido eliminado correctamente', 'danger');

        return redirect()->route('activo.index');
    }
}
