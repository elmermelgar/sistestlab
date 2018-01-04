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
        'rpt_pruebas.jrxml',
        'rpt_ref_especifica.jrxml',
        'rpt_suc_especifica.jrxml',
        'rpt_factura.jrxml',
        'rpt_registro.jrxml',
        'rpt_registro_detalle.jrxml',
        'rpt_existencias.jrxml',
        'rpt_lista_anulada.jrxml',
        'rpt_lista_examen.jrxml',
        'rpt_lista_factura.jrxml',
        'rpt_lista_niveles.jrxml',
        'rpt_lista_origen.jrxml',
        'rpt_lista_proveedor.jrxml',
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
     * @throws \Exception
     */
    public function rpt_mensajeria(Request $request)
    {
        $request->validate([
            'recolector_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $compiled_file = $this->report_path . 'rpt_mensajero.jasper';
        $subreport_compiled_file = $this->report_path . 'rpt_mensajero_bonos.jasper';
        $file_name = 'rpt_recolector_' . $request->recolector_id . Carbon::now()->format('Ymd');
        $output_file = $this->report_path . $file_name;

        $parameters = [
            'recolector_id' => $request->recolector_id,
            'fecha_inicio' => Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString(),
            'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString(),
            'subreport' => $subreport_compiled_file,
            'LoggedInUsername' => '"' . \Auth::user()->name . '"',
        ];

        return $this->process($compiled_file, $output_file, $parameters, $file_name);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pruebas()
    {
        $customers = \App\Customer::orderBy('name')->get();
        return view('report.pruebas', [
            'customers' => $customers
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function rpt_pruebas(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $compiled_file = $this->report_path . 'rpt_pruebas.jasper';
        $file_name = 'rpt_pruebas_' . $request->customer_id . Carbon::now()->format('Ymd');
        $output_file = $this->report_path . $file_name;

        $parameters = [
            'customer_id' => $request->customer_id,
            'fecha_inicio' => Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString(),
            'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString(),
            'LoggedInUsername' => '"' . \Auth::user()->name . '"',
        ];

        return $this->process($compiled_file, $output_file, $parameters, $file_name);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ref_especifica()
    {
        $customers = \App\Customer::orderBy('name')->get();
        $profiles = \App\Profile::orderBy('name')->get();
        return view('report.ref_especifica', [
            'customers' => $customers,
            'profiles' => $profiles
        ]);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function rpt_ref_especifica(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|min:1',
            'profile_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $compiled_file = $this->report_path . 'rpt_ref_especifica.jasper';
        $file_name = 'rpt_ref_especifica_' . $request->customer_id . Carbon::now()->format('Ymd');
        $output_file = $this->report_path . $file_name;

        $parameters = [
            'customer_id' => $request->customer_id,
            'profile_id' => $request->profile_id,
            'fecha_inicio' => Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString(),
            'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString(),
            'LoggedInUsername' => '"' . \Auth::user()->name . '"',
        ];

        return $this->process($compiled_file, $output_file, $parameters, $file_name);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function suc_especifica()
    {
        $sucursales = \App\Sucursal::all();
        $profiles = \App\Profile::orderBy('name')->get();
        return view('report.suc_especifica', [
            'sucursales' => $sucursales,
            'profiles' => $profiles
        ]);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function rpt_suc_especifica(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|integer|min:1',
            'profile_id' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
        ]);

        $compiled_file = $this->report_path . 'rpt_suc_especifica.jasper';
        $file_name = 'rpt_suc_especifica_' . $request->sucursal_id . Carbon::now()->format('Ymd');
        $output_file = $this->report_path . $file_name;

        $parameters = [
            'sucursal_id' => $request->sucursal_id,
            'profile_id' => $request->profile_id,
            'fecha_inicio' => Carbon::createFromFormat('d/m/Y', $request->fecha_inicio)->toDateString(),
            'fecha_fin' => Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->toDateString(),
            'LoggedInUsername' => '"' . \Auth::user()->name . '"',
        ];

        return $this->process($compiled_file, $output_file, $parameters, $file_name);
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

    /**
     * @param string $compiled_file
     * @param string $output_file
     * @param array $parameters
     * @param string $file_name
     * @return mixed
     * @throws \Exception
     */
    private function process($compiled_file, $output_file, $parameters, $file_name)
    {
        $file_extension = '.pdf';
        $jasper = new JasperPHP;

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

}
