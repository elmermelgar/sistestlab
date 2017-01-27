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
use Jleon\LaravelPnotify\Notify;

class ActivoController extends Controller
{
    /**
     * Lista de activos registrados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activos = Activo::all();
        return view('Inventario.Activo.activo_index')->with('activos',$activos);
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
        $sucursal = Sucursal::all();
        return view('Inventario.Activo.activo_create', array('proveedores'=>$proveedores, 'estados'=>$estado,'sucursales'=>$sucursal));
    }

    /**
     * Metodo de guardado de activo he inventario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->existencia<=$request->cantidad_maxima){
            $activo = new Activo($request->all());
            $fechaadq = DateTime::createFromFormat('d/m/Y', $request->fecha_adq);
            $activo->fecha_adq = $fechaadq;
            $activo->cod_inventario = $activo->id.$request->fecha_adq;
            $activo->save();
            $activo->cod_inventario = $activo->id.$request->fecha_adq;
            $activo->save();
            // Guardando el Inventario correspondiente al activo anterior
            $inventario = new Inventario();
            $inventario->cod_inventario = $activo->cod_inventario;
            $inventario->activo_id = $activo->id;
            $inventario->existencia = $request->existencia;
            $inventario->cantidad_minima = $request->cantidad_minima;
            $inventario->cantidad_maxima = $request->cantidad_maxima;
            if($request->fecha_vencimiento==''){

            }else{
                $inventario->fecha_vencimiento = DateTime::createFromFormat('m/d/Y', $request->fecha_vencimiento);
            }
            $inventario->fecha_cargado = $today = Carbon::today();
            $inventario->save();
            Notify::success('Activo '.$activo->nombre_activo.' Creado Correctamente', 'Exito!!');
            return redirect()->route('activo.index');
        }else{
            Notify::danger('La Existencia debe ser menor o igual a la cantidad máxima', 'Error!!');
            return redirect()->back();
        }

    }

    /**
     * Muestra el detalle del activo con su respectivo inventario.
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
     * Muestra el formulario de edicion del activo.
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
     * Muestra el formulario de edicion del iventario.
     *
     * @param  int  $id1
     * @param int $id2
     * @return \Illuminate\Http\Response
     */
    public function editinventario($id1,$id2)
    {
        $inventario = Inventario::find($id1);
        $activo = Activo::find($id2);
        return view('Inventario.Activo.inventario_edit', array('activo'=>$activo, 'inventario'=>$inventario));
    }


    /**
     * Actualiza el activo especificado.
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
        Notify::warning('Activo '.$activo->nombre_activo.' se actualizó correctamente', 'Actualización');
        return redirect()->route('activo.index');
    }

    /**
     * Metodo para actualizar los datos del inventario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id1
     * * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function updateinventario(Request $request, $id1, $id2)
    {
        if ($request->existencia <= $request->cantidad_maxima) {
            $inventario = Inventario::find($id1);
            $inventario->existencia = $request->existencia;
            $inventario->cantidad_minima = $request->cantidad_minima;
            $inventario->cantidad_maxima = $request->cantidad_maxima;
            if ($request->fecha_vencimiento == '') {

            } else {
                $inventario->fecha_vencimiento = DateTime::createFromFormat('m/d/Y', $request->fecha_vencimiento);
            }
            $inventario->save();
            Notify::warning('El inventario con codigo "' . $inventario->cod_inventario . '" ha sido actualizado correctamente', 'Actualización');
            return redirect()->route('activo.show', $id2);
        } else {
            Notify::danger('La "existencia" debe ser menor o igual a la "cantidad máxima"', 'Error!!');
            return redirect()->back();
        }
    }

    /**
     * Metodo para cargar existencias al inventario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id1
     * * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function cargarinventario(Request $request, $id1, $id2)
    {

            $inventario = Inventario::find($id1);
        if (($inventario->existencia + $request->cantidad) <= $inventario->cantidad_maxima) {
            $inventario->existencia = $inventario->existencia + $request->cantidad;
            $inventario->fecha_cargado = $today = Carbon::today();

            if ($request->fecha_vencimiento == '') {

            } else {
                $inventario->fecha_vencimiento = DateTime::createFromFormat('m/d/Y', $request->fecha_vencimiento);
            }
            $inventario->save();

            Notify::warning('El inventario con codigo "' . $inventario->cod_inventario . '" ha sido cargado con ' . $request->cantidad . ' unidades', 'Cargado');
            return redirect()->route('activo.show', $id2);
        } else {
            Notify::danger('La "existencia" debe ser menor o igual a la "cantidad máxima='.$inventario->cantidad_maxima.'"', 'Error!!');
            return redirect()->back();
        }
    }

    /**
     * Elimina un activo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activo = Activo::find($id);
        $inventario = Inventario::where(array('activo_id' => $id))->first();
        if($inventario){
            Notify::danger('El activo "'.$activo->nombre_activo.'" no puede ser eliminado porque posee registro asociado', 'Error!!');
            return redirect()->route('activo.index');
        }else{
            $activo->delete();
            Notify::warning('El activo "'.$activo->nombre_activo.'" ha sido eliminado correctamente', 'Eliminación');
            return redirect()->route('activo.index');
        }
    }
}
