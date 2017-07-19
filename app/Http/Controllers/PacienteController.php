<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Paciente;
use App\Services\UserService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class PacienteController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Muestra la cartera de pacientes
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('paciente.index', ['pacientes' => Paciente::filter($request->get('nombre'))->paginate(10)]);
    }

    /**
     * Muestra al paciente especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($paciente = Paciente::find($id)) {
            return view('paciente.show', ['paciente' => $paciente]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para registrar un nuevo paciente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('paciente.edit', ['paciente' => null, 'clientes' => Cliente::all()]);
    }

    /**
     * Muestra el formulario para editar a un paciente
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($paciente = Paciente::find($id)) {
            $cliente = $paciente->clientes()->wherePivot('same_record', true)->first();
            if ($cliente) {
                Notify::warning('Este paciente esta registrado como cliente; 
                para actualizar datos deberá editar el registro de cliente.');
                return back();
            }
            return view('paciente.edit', ['paciente' => $paciente, 'clientes' => Cliente::all()]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la información de un paciente
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->merge(['dui' => str_replace('-', '', $request->dui)]);
            $request->merge(['telefono' => str_replace('-', '', $request->telefono)]);
            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento);
            $request->merge(['fecha_nacimiento' => $fecha_nacimiento]);
            if ($request->id && $paciente = Paciente::find($request->id)) {
                $paciente->update($request->all());
            } else {
                $paciente = Paciente::create($request->all());
            }
            $paciente->clientes()->sync($request->cliente_id);

            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e);
            Notify::error('No se ha registrado al paciente');
            DB::rollBack();
            return back()->withInput();
        }

        Notify::success('Paciente registrado correctamente');
        return redirect()->action('PacienteController@show', ['paciente' => $paciente->id]);
    }

}
