<?php

namespace App\Http\Controllers\Inventario;

use App\Activo;
use App\Estado;
use App\Existencia;
use App\Inventario;
use App\Services\InventarioService;
use App\Sucursal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;
use Carbon\Carbon;

class InventarioController extends Controller
{
    /**
     * @var InventarioService
     */
    private $inventarioService;

    /**
     * InventarioController constructor.
     */
    public function __construct(InventarioService $inventarioService)
    {
        $this->middleware('auth');
        $this->inventarioService = $inventarioService;
    }

    /**
     * Muestra el formulario de edicion del iventario.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($activo = Activo::find($id)) {
            $inventarios = $activo->inventarios;
            $sucursales = Sucursal::all();
            return view('inventario.edit', [
                'activo' => $activo,
                'inventarios' => $inventarios,
                'sucursales' => $sucursales,
                'selected' => $inventarios->pluck('sucursal_id')->all(),
                'estados' => Estado::where('tipo', 'activo')->get(),
            ]);
        }
        return abort(404);
    }

    /**
     * Metodo para actualizar los datos del inventario.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id1
     * @param  int $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == $request->activo_id && $activo = Activo::find($request->id)) {
            //Empieza la transacción
            DB::beginTransaction();
            try {
                $sucursales = $activo->inventarios()->pluck('sucursal_id');
                $diff = $sucursales->diff($request->sucursal_id)->all();
                foreach ($diff as $sucursal_id) {
                    $inventario = Inventario::where('sucursal_id', $sucursal_id)
                        ->where('activo_id', $request->activo_id)->first();
                    $inventario->delete();
                }

                if (count($request->sucursal_id) > 0) {
                    foreach ($request->sucursal_id as $key => $sucursal_id) {
                        if (!$inventario = Inventario::where('sucursal_id', $sucursal_id)
                            ->where('activo_id', $request->activo_id)->first()) {
                            $inventario = new Inventario();
                            $inventario->sucursal_id = $sucursal_id;
                            $inventario->activo_id = $request->activo_id;
                        }
                        $inventario->estado_id = $request->estado_id[$key];
                        $inventario->ubicacion = $request->ubicacion[$key];
                        $inventario->minimo = $request->minimo[$key];
                        $inventario->maximo = $request->maximo[$key];
                        $inventario->save();
                    }
                }

                //Exito, hace efectivos todos los cambios en la base de datos
                DB::commit();

                Notify::success('El inventario con código "' . $activo->codigo() . '" ha sido actualizado correctamente');
                return redirect()->route('activo.show', $activo->id);

            } catch (\Exception $e) {
                //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
                DB::rollBack();
                if ($e instanceof ValidationException) {
                    foreach ($e->validator->errors()->all() as $error) {
                        Notify::error($error);
                    }
                }
                \Log::error($e);
            }
        }
        Notify::danger('No se actualizó ningun inventario', 'Error!!');
        return redirect()->back();
    }

    /**
     * Carga existencias al inventario.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cargar(Request $request)
    {
        if ($inventario = Inventario::where('sucursal_id', $request->sucursal_id)
            ->where('activo_id', $request->activo_id)->first()) {
            $fecha_adquisicion = Carbon::createFromFormat('d/m/Y', $request->fecha_adquisicion);
            $fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento);
            $request->merge(['fecha_adquisicion' => $fecha_adquisicion->toDateString()]);
            $request->merge(['fecha_vencimiento' => $fecha_vencimiento->toDateString()]);
            $data = $request->all();
            $resultado = $this->inventarioService->cargar($data);
            if ($resultado == 0) {
                Notify::success('El inventario con código "' . $inventario->activo->codigo()
                    . "\" ha sido cargado con $request->cantidad unidades");
                return redirect()->route('activo.show', $inventario->activo_id);
            }
            Notify::danger($this->inventarioService->messages[$resultado], 'Error!!');
        } else {
            Notify::danger('No existe el inventario especificado. ', 'Error!!');
        }
        return redirect()->back();
    }

    public function descargar(Request $request)
    {
        if ($inventario = Inventario::where('sucursal_id', $request->sucursal_id)
            ->where('activo_id', $request->activo_id)->first()) {
            $resultado = $this->inventarioService->descargar(
                $inventario->sucursal_id, $inventario->activo_id, $request->cantidad);
            if ($resultado == 0) {
                Notify::success('El inventario con codigo "' . $inventario->activo->codigo() .
                    '" ha sido cargado con ' . $request->cantidad . ' unidades', 'Cargado');
                return redirect()->route('activo.show', $inventario->activo_id);
            }
            Notify::danger($this->inventarioService->messages[$resultado], 'Error!!');
        } else {
            Notify::danger('No existe el inventario especificado. ', 'Error!!');
        }
        return redirect()->back();
    }

    /**
     * Muestra la existencia .
     *
     * @return \Illuminate\Http\Response
     */
    public function existencia()
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
    public function existencia_edit()
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
    public function existencia_update(Request $request, $id)
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

}
