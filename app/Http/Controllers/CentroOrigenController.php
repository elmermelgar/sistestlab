<?php

namespace App\Http\Controllers;

use App\CentroOrigen;
use App\Cliente;
use App\Role;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class CentroOrigenController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * CentroOrigenController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * Muestra la lista de los centros de centro-origen
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('centro-origen.index', ['origenes' => CentroOrigen::all()]);
    }

    /**
     * Muestra el centro de centro-origen especificado
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($origen = CentroOrigen::find($id)) {
            return redirect()->action('ClienteController@show',['id'=>$id]);
            return view('centro-origen.show', ['centro-origen' => $origen]);
        }
        return abort(404);
    }

    /**
     * Muestra el formulario para crear un centro de centro-origen
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('centro-origen.edit', ['origen' => null]);
    }

    /**
     * Muesta el formulacio para editar un centro de centro-origen
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($origen = CentroOrigen::find($id)) {
            return view('centro-origen.edit', ['origen' => $origen]);
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //Empieza la transacción
        DB::beginTransaction();

        try {
            $request->merge(['nit' => str_replace('-', '', $request->nit)]);
            $request->merge(['nrc' => str_replace('-', '', $request->nrc)]);
            $request->merge(['telefono' => str_replace('-', '', $request->telefono)]);
            $request->merge(['descripcion' => $request->display_name]);
            if ($request->id && $origen = CentroOrigen::find($request->id)) {
                $origen->cliente->update($request->all());
                if($origen->cliente->user){
                    $origen->cliente->user->update($this->userService->userDataFromCustomer($request->all()));
                }
                $origen->update($request->all());
            } else {
                $cliente = Cliente::create($request->all());
                $user = $this->createUserForCustomer($request);
                $cliente->user()->associate($user);
                $cliente->save();
                $origen = new CentroOrigen();
                $origen->cliente()->associate($cliente);
                $origen->fill($request->all());
                $origen->save();
            }

            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            Notify::error('No se ha podido registrar el centro de centro-origen');
            \Log::error($e);
            return back()->withInput();
        }

        //Se completó el registro del centro de centro-origen exitosamente
        Notify::success('Centro de centro-origen registrado correctamente');
        return redirect()->action('CentroOrigenController@show', ['id' => $origen->id]);
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
