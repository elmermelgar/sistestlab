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

            if ($request->id && $cliente = Cliente::find($request->id)) {
                $user = $cliente->user;
                $cliente->update($request->all());
            } else {
                //Crea el usuario del cliente
                $data = $this->userDataFromCustomer($request->all());
                $user = $this->userService->createUser($data);
                $role = Role::where('name', 'cliente')->first();
                $user->attachRole($role);

                //habilita el usuario y envía link para establecer contraseña, sino lo deshabilita
                if ($request->user) {
                    $this->userService->sendResetLink($user);
                } else {
                    $user->enabled = false;
                    $user->save();
                }
                $request->merge(['user_id' => $user->id]);

                //Registra al cliente
                $cliente = Cliente::create($request->all());
            }

            //Crea y asocia al cliente como paciente
            if ($request->paciente) {
                $request->merge(['fecha_nacimiento'=>Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)]);
                $paciente = $cliente->pacientes()->wherePivot('same_record', true)->first();
                if (!$paciente) {
                    $paciente = Paciente::create($request->all());
                }
                else{
                    $paciente->update($request->all());
                }
                $cliente->pacientes()->syncWithoutDetaching([$paciente->id => ['same_record' => true]]);
            }

            //Almacena el avatar del cliente
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $this->userService->storageAvatar($request->file('avatar'), $user);
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
     * Obtiene los datos necesarios para crear un usuario a partir del cliente
     * @param array $data
     * @return array
     */
    public function userDataFromCustomer(array $data)
    {
        if (array_has($data, 'nombre')) {
            $data['name'] = $data['nombre'];
        } else {
            $data['name'] = $data['razon_social'];
        }
        if (array_has($data, 'apellido')) {
            $data['surname'] = $data['apellido'];
        }
        return $data;
    }

}
