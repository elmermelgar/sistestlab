<?php

namespace App\Http\Controllers;

use App\Inventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class InventarioController extends Controller
{
    /**
     * Muestra la existencia .
     *
     * @return \Illuminate\Http\Response
     */
    public function consumir()
    {
        $inventario = Inventario::all();
        $nom = '';
        foreach ($inventario as $inv) {
            if ($inv->fecha_vencimiento) {
                $today = Carbon::today();
                $venimiento = Carbon::createFromFormat('Y-m-d', $inv->fecha_vencimiento)->subMonth();
                if ($venimiento <= $today) {
                    $nom = $nom . '<br/>' . '-' . $inv->activo->nombre_activo;
                }
            }
        }
        if ($nom == '') {

        } else {
            Notify::error('Lista de rectivos próximo a vencerse' . $nom . '', 'Próximo a vencerse')->sticky();
        }
        return view('inventario.reactivos', ['inventario' => $inventario]);
    }

    /**
     * Muestra para Actualizar la existencia del inventario si se consume reactivo.
     *
     * @return \Illuminate\Http\Response
     */
    public function consumiredit()
    {
        $inventario = Inventario::all();
        return view('inventario.reactivos_edit', ['inventario' => $inventario]);
    }

    /**
     * Muestra el formulario de edicion del activo.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function consumirupdate(Request $request, $id)
    {
        $inventario = Inventario::find($id);
        if ($request->valor <= ($inventario->cantidad_maxima - $inventario->existencia)) {
            Notify::danger('Introduzca un valor correcto', 'Error');
        } else {
            $inventario->existencia = $inventario->cantidad_maxima - $request->valor;
            $inventario->save();
            Notify::warning('inventario del activo ' . $inventario->activo->nombre_activo . ' actualizado', 'Actualización');
        }
        return redirect()->route('activo.reactivo.edit');
    }

    /**
     * Muestra el formulario de edicion del iventario.
     *
     * @param  int $id1
     * @param int $id2
     * @return \Illuminate\Http\Response
     */
    public function editinventario($id1, $id2)
    {
        $inventario = Inventario::find($id1);
        $vencimiento = Carbon::parse($inventario->fecha_vencimiento)->format('m/d/Y');
        $activo = Activo::find($id2);
        return view('inventario.activo.inventario_edit', [
            'activo' => $activo, 'inventario' => $inventario, 'fecha_vencimiento' => $vencimiento
        ]);
    }

    /**
     * Metodo para actualizar los datos del inventario.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id1
     * @param  int $id2
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
                $inventario->fecha_vencimiento = Carbon::createFromFormat('m/d/Y', $request->fecha_vencimiento);
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id1
     * @param  int $id2
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
                $inventario->fecha_vencimiento = Carbon::createFromFormat('m/d/Y', $request->fecha_vencimiento);
            }
            $inventario->save();

            Notify::warning('El inventario con codigo "' . $inventario->cod_inventario . '" ha sido cargado con ' . $request->cantidad . ' unidades', 'Cargado');
            return redirect()->route('activo.show', $id2);
        } else {
            Notify::danger('La "existencia" debe ser menor o igual a la "cantidad máxima=' . $inventario->cantidad_maxima . '"', 'Error!!');
            return redirect()->back();
        }
    }

    public function cargar(Request $request)
    {
        if ($request->existencia <= $request->cantidad_maxima) {

            $fecha_adq = Carbon::createFromFormat('d/m/Y', $request->fecha_adq);
            $cod_inventario = $activo->id . $fecha_adq;

            // Guardando el inventario correspondiente al activo anterior
            $inventario = new Inventario();
            $inventario->cod_inventario = $cod_inventario;
            $inventario->activo_id = $activo->id;
            $inventario->existencia = $request->existencia;
            $inventario->cantidad_minima = $request->cantidad_minima;
            $inventario->cantidad_maxima = $request->cantidad_maxima;
            if ($request->fecha_vencimiento != '') {
                $inventario->fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento);
            }
            $inventario->fecha_cargado = Carbon::today();
            $inventario->save();
        } else {
            Notify::danger('La Existencia debe ser menor o igual a la cantidad máxima', 'Error!!');
            return redirect()->back();
        }

    }
}
