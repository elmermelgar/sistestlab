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
use Illuminate\Validation\Rule;
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
        $clientes = Customer::where('origin_center', false)->filter($request->name)->paginate(9);
        return view('cliente.index', ['clientes' => $clientes]);
    }

    /**
     * Muestra la lista de centros de origen
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function origenes(Request $request)
    {
        $clientes = Customer::where('origin_center', true)->filter($request->name)->paginate(9);
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
                'paciente' => $cliente->account->patient,
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
            $request->juridical_person ? $juridical_person = true : $juridical_person = false;
            $request->merge(['juridical_person' => $juridical_person]);


            //Si el cliente ya esta registrado, lo actualiza, de lo contrario, registra al cliente
            if ($request->id && $cliente = Customer::find($request->id)) {
                $this->validate($request, $this->rules($cliente->id, $cliente->account_id));
                $cliente->update($request->all());
                //$cliente->account->update($request->all());
            } else {
                $this->validate($request, $this->rules());
                $cliente = Customer::create($request->all());
            }

            $cliente->refresh();
            //Si el cliente tiene un usuario, lo actualiza, o se le habilita un usuario si se especificó
            if ($cliente->account->user) {
                $cliente->account->user->update($request->only('email'));
                //Almacena el avatar del cliente
                if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                    $this->userService->storageAvatar($request->file('avatar'), $cliente->account);
                }
            } else if ($request->user) {
                $request->merge(['account_id' => $cliente->account_id]);
                $user = $this->createUserForCustomer($request);
            }

            //Crea y asocia al cliente como paciente
            if ($request->patient) {
                $paciente = $cliente->account->patient;
                if ($paciente) {
                    $request->merge(['account_id' => null]);
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
        return redirect()->action('CustomerController@show', ['cliente' => $cliente->id]);
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
     * @param int $customer_id
     * @param int $account_id
     * @return array
     */
    private function rules($customer_id = null, $account_id = null)
    {
        return [
            'sucursal_id' => 'required|integer|min:1',
            'identity_document' => ['max:9', Rule::unique('accounts_dui_vw')->ignore($account_id)],
            'first_name' => 'required|max:127',
            'last_name' => 'max:127',
            'phone_number' => 'required|max:8',
            'address' => 'max:255',
            'birth_date' => 'date_format:Y-m-d',
            'sex' => 'max:1',
            'juridical_person' => 'boolean',
            'origin_center' => 'boolean',
            'tradename' => 'max:127',
            'nit' => ['max:14', Rule::unique('customers_nit_vw')->ignore($customer_id)],
            'nrc' => ['max:7', Rule::unique('customers_nit_vw')->ignore($customer_id)],
            'business' => 'max:127',
            'comment' => 'max:255',
        ];
    }

}
