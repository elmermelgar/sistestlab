<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Patient;
use App\Role;
use App\Services\UserService;

use App\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;
use Swift_TransportException;

class CustomerController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $clientes = Customer::where('origin_center', false)->filter($request->razon_social)->paginate(9);
        return view('cliente.index', ['clientes' => $clientes]);
    }

    /**
     * Muestra la lista de centros de origen
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function origenes(Request $request)
    {
        $clientes = Customer::where('origin_center', true)->filter($request->razon_social)->paginate(9);
        return view('cliente.index', ['clientes' => $clientes, 'origen' => true]);
    }

    /**
     * Muestra al cliente especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($cliente = Customer::find($id)) {
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
        return view('cliente.edit', ['cliente' => null, 'paciente' => null, 'sucursales' => Sucursal::all()]);
    }

    /**
     * Muestra el formulario para editar a un cliente
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($cliente = Customer::find($id)) {
            return view('cliente.edit', [
                'cliente' => $cliente,
                'paciente' => $cliente->patients()->first(),
                'sucursales' => Sucursal::all(),
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
            $request->identity_document ? $request->merge(['identity_document' => str_replace('-', '', $request->identity_document)]) : null;
            $request->nit ? $request->merge(['nit' => str_replace('-', '', $request->nit)]) : null;
            $request->nrc ? $request->merge(['nrc' => str_replace('-', '', $request->nrc)]) : null;
            $request->merge(['phone_number' => str_replace('-', '', $request->phone_number)]);
            $request->origin_center ? $origin_center = true : $origin_center = false;
            $request->merge(['origin_center' => $origin_center]);

            $this->validate($request, $this->rules());
            //Si el cliente ya esta registrado, lo actualiza, de lo contrario, registra al cliente
            if ($request->id && $cliente = Customer::find($request->id)) {
                $cliente->update($request->only(['juridical_person', 'origin_center', 'nit', 'nrc', 'business']));
                $cliente->account->update($request->all());
            } else {
                $cliente = Customer::create($request->all());
            }

            $cliente->refresh();
            //Si el cliente tiene un usuario, lo actualiza, o se le habilita un usuario si se especificó
            if ($cliente->account->user) {
                $cliente->account->user->update($request->only('email'));
            } else if ($request->user) {
                $request->merge(['account_id' => $cliente->account_id]);
                $user = $this->createUserForCustomer($request);
            }

            //Crea y asocia al cliente como paciente
            if ($request->patient) {
                $request->merge(['birth_date' => Carbon::createFromFormat('d/m/Y', $request->birth_date)]);
                $paciente = $cliente->account->patient;
                if ($paciente) {
                    $paciente->update($request->only(['birth_date', 'sex']));
                } else {
                    $request->merge(['account_id' => $cliente->account->id]);
                    $paciente = Patient::create($request->only(['account_id', 'birth_date', 'sex']));
                }
                //$cliente->patients()->syncWithoutDetaching([$paciente->id => ['same_record' => true]]);
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return back()->withInput()->withErrors($e->validator->errors());
            }
            Notify::error('Ha ocurrido un error al registrar al cliente');
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
            $this->userService->storageAvatar($request->file('avatar'), $user->account);
        }

        //habilita el usuario y envía link para establecer contraseña
        $this->userService->sendResetLink($user);

        return $user;
    }

    /**
     * Reglas para validar la petición
     * @return array
     */
    private function rules()
    {
        return [
            'sucursal_id' => 'required|integer|min:1',
            'identity_document' => 'max:9|unique:accounts',
            'first_name' => 'required|max:127',
            'last_name' => 'max:127',
            'phone_number' => 'required|max:8',
            'address' => 'max:255',
            'juridical_person' => 'boolean',
            'origin_center' => 'boolean',
            'nit' => 'max:14|unique:customers_nit_vw',
            'nrc' => 'max:7|unique:customers_nit_vw',
            'business' => 'max:127',
            'comment' => 'max:255',
        ];
    }

}
