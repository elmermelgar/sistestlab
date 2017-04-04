<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Paciente;
use App\Role;
use App\Services\UserService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;
use Swift_TransportException;

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
            if($cliente->origen){
                Notify::warning('Este cliente pertenece a un centro de centro-origen; 
                para actualizar datos deberá editar el registro de centro de centro-origen.');
                return back();
            }
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
        //Empieza la transacción
        DB::beginTransaction();

        try {
            $request->merge(['dui' => str_replace('-', '', $request->dui)]);
            $request->merge(['nit' => str_replace('-', '', $request->nit)]);
            $request->merge(['nrc' => str_replace('-', '', $request->nrc)]);
            $request->merge(['telefono' => str_replace('-', '', $request->telefono)]);

            //Si el cliente ya esta registrado, lo actualiza, de lo contrario, registra al cliente
            if ($request->id && $cliente = Cliente::find($request->id)) {
                $cliente->update($request->all());
            } else {
                $cliente = Cliente::create($request->all());
            }

            //Si el cliente tiene un usuario, lo actualiza, o se le habilita un usuario si se especificó
            if ($cliente->user) {
                $cliente->user->update($this->userService->userDataFromCustomer($request->all()));
            } else if ($request->user) {
                $user = $this->createUserForCustomer($request);
                $cliente->user()->associate($user);
                $cliente->save();
            }

            //Crea y asocia al cliente como paciente
            if ($request->paciente) {
                $request->merge(['fecha_nacimiento' => Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)]);
                $paciente = $cliente->pacientes()->wherePivot('same_record', true)->first();
                if ($paciente) {
                    $paciente->update($request->all());
                } else {
                    $paciente = Paciente::create($request->all());
                }
                $cliente->pacientes()->syncWithoutDetaching([$paciente->id => ['same_record' => true]]);
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            if ($e instanceof ValidationException) {
                foreach ($e->validator->errors()->all() as $error) {
                    Notify::error($error);
                }
                return back()->withInput();
            }
            if ($e instanceof Swift_TransportException) {
                Notify::error('No se ha podido enviar el email con los datos de la cuenta al usuario');
            }
            \Log::error($e);
            return back()->withInput();
        }

        //Se completó el registro del cliente exitosamente
        Notify::success('Cliente registrado correctamente');
        return redirect()->action('ClienteController@show', ['cliente' => $cliente->id]);
    }

    /**
     * @param Request $request
     * @return \App\User
     */
    public function createUserForCustomer(Request $request)
    {
        //Crea el usuario del cliente
        $data = $this->userService->userDataFromCustomer($request->all());
        $user = $this->userService->createUser($data);
        $role = Role::where('name', 'cliente')->first();
        $user->attachRole($role);

        //Almacena el avatar del cliente
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $this->userService->storageAvatar($request->file('avatar'), $user);
        }

        //habilita el usuario y envía link para establecer contraseña
        $this->userService->sendResetLink($user);

        return $user;
    }

}
