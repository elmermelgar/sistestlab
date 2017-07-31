<?php


namespace App\Services;


use App\Existencia;
use App\Inventario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventarioService
{
    /**
     * Constantes de resultados a retornar
     */
    const CORRECTO = 0;
    const INVENTARIO_NO_EXISTE = 1;
    const EXISTENCIA_MAYOR_QUE_MAXIMO = 2;
    const EXISTENCIA_INSUFICIENTE = 3;
    const ERROR_INESPERADO = 4;

    /**
     * Mensajes correspondientes a resultados
     * @var array
     */
    public $messages = [
        0 => 'Transacción correcta',
        1 => 'No existe el inventario especificado',
        2 => 'La existencia debe ser menor o igual a la cantidad máxima',
        3 => 'No hay existencias suficientes',
        4 => 'Error inesperado, contacte al administrador técnico',
    ];

    public function cargar(array $data)
    {
        $this->validator($data)->validate();
        $inventario = Inventario::where('sucursal_id', $data['sucursal_id'])
            ->where('activo_id', $data['activo_id'])->first();
        if ($inventario) {
            $suma = $inventario->existencias()->sum('cantidad') + $data['cantidad'];

            if ($suma <= $inventario->maximo) {
                //Empieza la transacción
                DB::beginTransaction();
                try {
                    Existencia::create($data);
                    //Exito, hace efectivos todos los cambios en la base de datos
                    DB::commit();
                    return self::CORRECTO;
                } catch (\Exception $e) {
                    //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
                    DB::rollBack();
                    \Log::error($e);
                    return self::ERROR_INESPERADO;
                }
            }
            return self::EXISTENCIA_MAYOR_QUE_MAXIMO;
        }
        return self::INVENTARIO_NO_EXISTE;

    }

    /**
     * @param $sucursal_id
     * @param $activo_id
     * @param $cantidad
     * @return int
     */
    public function descargar($sucursal_id, $activo_id, $cantidad)
    {
        $inventario = Inventario::where('sucursal_id', $sucursal_id)
            ->where('activo_id', $activo_id)->first();
        if ($inventario && $this->verificar_existencia($inventario, $cantidad)) {
            DB::beginTransaction();
            try {
                foreach ($inventario->existencias() as $existencia) {
                    $diff = $existencia->cantidad - $cantidad;
                    if ($diff > 0) {
                        $existencia->update(['cantidad' => $diff]);
                    } elseif ($diff == 0) {
                        $existencia->delete();
                    } else {
                        $existencia->delete();
                        $cantidad = -$diff;
                        continue;
                    }
                    break;
                }
                //Exito, hace efectivos todos los cambios en la base de datos
                DB::commit();
                return self::CORRECTO;
            } catch (\Exception $e) {
                //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
                DB::rollBack();
                \Log::error($e);
                return self::ERROR_INESPERADO;
            }
        }
        return self::EXISTENCIA_INSUFICIENTE;
    }

    /**
     * @param Inventario $inventario
     * @param $cantidad
     * @return bool
     */
    private function verificar_existencia(Inventario $inventario, $cantidad)
    {
        if ($inventario->existencias()->sum('cantidad') >= $cantidad) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    private function verificar_vencimiento()
    {
        return [];
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'sucursal_id' => 'required',
            'activo_id' => 'required',
            'cantidad' => 'required|min:1',
            'precio' => 'required|min:0',
            'lote' => 'nullable|max:255',
            'fecha_adquisicion' => 'date_format:Y-m-d',
            'fecha_vencimiento' => 'date_format:Y-m-d',
        ]);
    }

}