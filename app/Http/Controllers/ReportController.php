<?php

namespace App\Http\Controllers;

use App\Recolector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use JasperPHP\JasperPHP;

class ReportController extends Controller
{
    /**
     * @var array
     */
    public static $report_list = [
        'rpt_mensajero.jrxml',
        'rpt_mensajero_bonos.jrxml',
        'rpt_referencia.jrxml',
    ];

    /**
     * @var string
     */
    private $report_path;

    /**
     * ReportController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->report_path = storage_path('app/reports/');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('report.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mensajeria()
    {
        $recolectores = Recolector::where('activo', true)->get();
        return view('report.mensajeria', [
            'recolectores' => $recolectores
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function rpt_mensajeria(Request $request)
    {
        $request->validate([
            'recolector_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $recolector_id = $request->recolector_id;
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();
        $fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString();

        $jasper = new JasperPHP;
        $compiled_file = $this->report_path . 'rpt_mensajero.jasper';
        $subreport_compiled_file = $this->report_path . 'rpt_mensajero_bonos.jasper';
        $file_name = 'rpt_recolector_' . $recolector_id . Carbon::now()->format('Ymd');
        $file_extension = '.pdf';
        $output_file = $this->report_path . $file_name;
        $parameters = [
            'recolector_id' => $recolector_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'subreport' => $subreport_compiled_file,
            'LoggedInUsername' => "'" . \Auth::user()->name . "'",
        ];

        $jasper->process(
            $compiled_file,
            $output_file,
            ["pdf"],
            $parameters,
            $this->db_connection()
        )->execute();

        return Response::make(file_get_contents($output_file . $file_extension), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename='$file_name.$file_extension'"
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function referencia()
    {
        $customers = \App\Customer::orderBy('name')->get();
        return view('report.referencia', [
            'customers' => $customers
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function rpt_referencia(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $customer_id = $request->customer_id;
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString();
        $fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString();

        $jasper = new JasperPHP;
        $compiled_file = $this->report_path . 'rpt_referencia.jasper';
        $file_name = 'rpt_referencia_' . $customer_id . Carbon::now()->format('Ymd');
        $file_extension = '.pdf';
        $output_file = $this->report_path . $file_name;
        $parameters = [
            'customer_id' => $customer_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'LoggedInUsername' => "'" . \Auth::user()->name . "'",
        ];

        $jasper->process(
            $compiled_file,
            $output_file,
            ["pdf"],
            $parameters,
            $this->db_connection()
        )->execute();

        return Response::make(file_get_contents($output_file . $file_extension), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename='$file_name.$file_extension'"
        ]);
    }


    /**
     * Conexión a la base de datos
     * @return array
     */
    private function db_connection()
    {
        return [
            'driver' => 'postgres',
            'username' => config('database.connections.pgsql.username'),
            'password' => config('database.connections.pgsql.password'),
            'host' => config('database.connections.pgsql.host'),
            'database' => config('database.connections.pgsql.database'),
            'port' => config('database.connections.pgsql.port'),
        ];
    }
}
