<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Paciente;
use App\Role;
use App\Services\UserService;

use Carbon\Carbon;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class ClienteController extends Controller
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
     * Muestra la cartera de clientes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cliente.index', ['clientes' => Cliente::all()]);
    }

    /**
     * Muestra al cliente especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($cliente = Cliente::find($id)) {
            return view('cliente.show', ['cliente' => $cliente]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para registrar un nuevo cliente
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('cliente.edit', ['cliente' => null, 'paciente' => null]);
    }

    /**
     * Muestra el formulario para editar a un cliente
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($cliente = Cliente::find($id)) {
            return view('cliente.edit', [
                'cliente' => $cliente,
                'paciente' => $cliente->pacientes()->wherePivot('same_record', true)->first(),
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la información de un cliente
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            if ($request->id && $cliente = Cliente::find($request->id)) {
                $user = $cliente->user;
                $cliente->update($request->only(['razon_social', 'documento_identidad', 'telefono', 'direccion']));
            } else {
                //Crea el usuario del cliente
                $request->merge(['name' => $request->razon_social]);
                $user = $this->userService->createUser($request->only(['name', 'email', 'password']));
                $role = Role::where('name', 'cliente')->first();
                $user->attachRole($role);

                //si se habilitó el usuario envía link para establecer contraseña, sino lo deshabilita
                if ($request->user) {
                    $this->userService->sendResetLink($user);
                } else {
                    $user->enabled = false;
                    $user->save();
                }
                $cliente = new Cliente();
                $cliente->user()->associate($user);
                $cliente->razon_social = $request->razon_social;
                $cliente->documento_identidad = $request->documento_identidad;
                $cliente->telefono = $request->telefono;
                $cliente->direccion = $request->direccion;
                $cliente->save();
            }
            if ($request->paciente) {
                $paciente = $cliente->pacientes()->wherePivot('same_record', true)->first();
                if (!$paciente) {
                    $paciente = new Paciente();
                    $paciente->nombre = $request->razon_social;
                    $paciente->apellido = '';
                    $paciente->documento_identidad = $request->documento_identidad;
                    $paciente->genero = 'Masculino';
                    $paciente->fecha_nacimiento = Carbon::now();
                    $paciente->telefono = $request->telefono;
                    $paciente->email = $request->email;
                    $paciente->save();
                    $cliente->pacientes()->attach($paciente->id, ['same_record' => true]);
                }
            }
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $this->userService->storageAvatar($request->file('avatar'), $user);
            }

            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e);
            Notify::error('No se ha registrado al cliente');
            DB::rollBack();
            return back()->withInput();
        }

        Notify::success('Cliente registrado correctamente');
        return redirect()->action('ClienteController@show', ['cliente' => $cliente->id]);
    }

}
