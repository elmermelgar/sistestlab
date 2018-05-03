<?php

namespace App\Services;


use App\BoxRegistry;
use App\Sucursal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SucursalService
{

    /**
     * Constante para el estado de caja cerrada
     */
    const CLOSED = 0;

    /**
     * Constante para el estado de caja abierta
     */
    const OPEN = 1;

    /**
     * Ruta donde se almacenan los sellos, relativo al directorio de almacenamiento publico
     * /storage/app/public/
     * @var string
     */
    private $sealPath = 'seals';

    /**
     * Verifica si la caja de una sucursal esta abierta
     * @param int $sucursal_id
     * @return bool
     */
    public static function isOpen($sucursal_id)
    {
        return DB::select("select is_open($sucursal_id)")[0]->is_open;
    }

    /**
     * Abre la caja de la sucursal especificada
     * @param int $sucursal_id
     * @param int $account_id
     * @param $cash
     * @return bool
     */
    public function openBox($sucursal_id, $account_id, $cash = 0)
    {
        return DB::select("select open_box($sucursal_id,$account_id,$cash)");
    }

    /**
     * Cierra la caja de la sucursal especificada
     * @param int $sucursal_id
     * @param int $account_id
     * @return bool
     */
    public function cerrarCaja($sucursal_id, $account_id = 0)
    {
        return DB::select("select close_box($sucursal_id,$account_id)");
    }

    /**
     * Retorna la caja actual de la sucursal especificada
     * @param int $sucursal_id
     * @return array
     */
    public function getBox($sucursal_id)
    {
        $box = DB::select("select * from get_box($sucursal_id)");
        return reset($box);
    }

    /**
     * @param int $sucursal_id
     * @param int $paginate
     * @param int $page
     * @return mixed
     */
    public function getRegistry($sucursal_id, $paginate = 6, $page = 1)
    {
        return DB::select("select * from get_registry($sucursal_id,$paginate,$page)");
    }

    /**
     * @param int $sucursal_id
     * @param string $start_date
     * @param string $end_date
     * @return mixed
     */
    public function getRegistryByDate($sucursal_id, $start_date, $end_date)
    {
        return DB::select("select * from get_registry_by_date($sucursal_id,'$start_date','$end_date');");
    }

    /**
     * Obtiene el efectivo actual de la caja
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getCash($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        //Efectivo al abrir caja más pagos en facturación y cobros
        return DB::select("select get_cash($sucursal_id, 
            '$opening->date $opening->time', '$closing->date $closing->time')")[0]->get_cash;
    }

    /**
     * Obtiene el debito actual de la caja
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getDebit($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        //Pagos en débito durante la facturación
        return DB::select("select get_debit($sucursal_id, 
            '$opening->date $opening->time', '$closing->date $closing->time')")[0]->get_debit;
    }

    /**
     * Obtiene los pagos en facturación de una caja para calcular la deuda
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getPayment($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        return DB::select("select get_payment($sucursal_id, 
            '$opening->date $opening->time', '$closing->date $closing->time')")[0]->get_payment;
    }

    /**
     * Obtiene los cobros realizados durante la apertura y cierre de caja
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getCharge($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        return DB::select("select get_charge($sucursal_id, 
            '$opening->date $opening->time', '$closing->date $closing->time')")[0]->get_charge;
    }

    /**
     * Obtiene la venta actual desde que la caja fue abierta
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getBilling($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        return DB::select("select get_billing($sucursal_id,
            '$opening->date $opening->time','$closing->date $closing->time')")[0]->get_billing;
    }

    /**
     * Obtiene el costo actual desde que la caja fue abierta
     * @param int $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return float
     */
    private function getCost($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        $closing = $this->checkClosing($closing);
        return DB::select("select get_cost($sucursal_id,
            '$opening->date $opening->time','$closing->date $closing->time')")[0]->get_cost;
    }

    /**
     * @param BoxRegistry $closing
     * @return BoxRegistry
     */
    private function checkClosing(BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->date = Carbon::now()->toDateString();
            $closing->time = Carbon::now()->toTimeString();
        }
        return $closing;
    }

    /**
     * Almacena la imagen del sello como un archivo imagen
     * @param UploadedFile $file
     * @param Sucursal $sucursal
     */
    public function storageSealSucursal(UploadedFile $file, Sucursal $sucursal)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'sello-sucursal-' . $sucursal->name . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        Storage::disk('public')->putFileAs($this->sealPath, $file, $filename);
        $sucursal->seal ? Storage::disk('public')->delete($this->sealPath . '/' . $sucursal->seal) : null;
        $sucursal->seal = $filename;
        $sucursal->save();
    }

}