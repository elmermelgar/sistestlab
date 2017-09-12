<?php

namespace App\Http\Controllers;

use App\Account;
use App\Role;
use App\Services\UserService;
use App\Sucursal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;
use Ramsey\Uuid\Uuid;
use Swift_TransportException;

class UserController extends Controller
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
     * Lista de usuarios del sistema
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::filter($request->email)->orderByRaw('last_login desc nulls last')->paginate(10);
        return view('user.index', ['users' => $users]);
    }

    /**
     * Muestra al usuario especificado
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id = null)
    {
        if ($id && $user = User::find($id)) {
            return view('user.show', ['user' => $user]);
        } else if (!$id) {
            return view('user.show', ['user' => Auth::user()]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.edit', [
            'user' => null,
            'sucursales' => Sucursal::all(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Muestra el formulario para editar un usuario
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id = null)
    {
        if (is_null($id)) {
            $id = Auth::id();
            $own = true;
        } else {
            $own = false;
        }
        if ($user = User::find($id)) {
            if (!$own && $user->account->cliente) {
                Notify::warning('Este usuario pertenece a un cliente; 
                para actualizar datos deberá editar el registro de cliente.');
                return back();
            }
            return view('user.edit', [
                'user' => $user,
                'sucursales' => Sucursal::all(),
                'roles' => Role::all(),
                'own' => $own,
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la informacion de un usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        //Empieza la transacción
        DB::beginTransaction();

        try {
            $request->merge(['phone_number' => str_replace('-', '', $request->phone_number)]);
            $this->validate($request, $this->rules($own = true));

            $user = Auth::user();
            $user->account->update($request->all());
            $user->update($request->only(['email']));

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $this->userService->storageAvatar($request->file('avatar'), $user->account);
            }
            if ($request->hasFile('seal') && $request->file('seal')->isValid()) {
                $this->userService->storageSeal($request->file('seal'), $user->account);
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();
        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return back()->withInput()->withErrors($e->validator->errors());
            }
            Notify::error('Ha ocurrido un error al actualizar la cuenta');
            \Log::error($e);
            return back()->withInput();
        }

        //Se completó el registro del cliente exitosamente
        Notify::success('Cuenta actualizada correctamente');
        return redirect()->route('cuenta');
    }

    /**
     * Almacena la información de un usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //Empieza la transacción
        DB::beginTransaction();

        try {
            $request->merge(['phone_number' => str_replace('-', '', $request->phone_number)]);
            $this->validate($request, $this->rules());

            if ($request->id && $user = User::find($request->id)) {
                $user->account->update($request->all());
                $user->update($request->only(['email']));
            } else {
                $account = Account::create($request->all());
                $request->merge(['account_id' => $account->id]);
                $request->merge(['name' => $request->first_name . ' ' . $request->last_name]);
                $user = $this->userService->createUser($request->all());
                $this->userService->sendResetLink($user);
            }
            if ($roles = $request->input('roles')) {
                $this->userService->assignRoles($roles, $user);
            }
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $this->userService->storageAvatar($request->file('avatar'), $user->account);
            }
            if ($request->hasFile('seal') && $request->file('seal')->isValid()) {
                $this->userService->storageSeal($request->file('seal'), $user->account);
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();
        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return back()->withInput()->withErrors($e->validator->errors());
            }
            Notify::error('Ha ocurrido un error al registrar al usuario');
            if ($e instanceof Swift_TransportException) {
                Notify::error('No se ha podido enviar el email con los datos de la cuenta al usuario');
            }
            \Log::error($e);
            return back()->withInput();
        }

        //Se completó el registro del usuario exitosamente
        Notify::success('Usuario registrado correctamente');
        return redirect()->route('user.show', ['id' => $user->id]);
    }

    /**
     * Deshabilita el usuario espeficado
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        if ($request->user_id) {
            if ($this->userService->disable($request->user_id)) {
                Notify::success('Se deshabilitó al usuario');
                return redirect()->back();
            }
        }
        Notify::warning('No se deshabilitó al usuario');
        return redirect()->back();
    }

    /**
     * Habilita el usuario espeficado
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request)
    {
        if ($request->user_id) {
            if ($this->userService->enable($request->user_id)) {
                Notify::success('Se habilitó al usuario');
                return redirect()->back();
            }
        }
        Notify::warning('No se habilitó al usuario');
        return redirect()->back();
    }

    /**
     * Reglas para validar la petición
     * @param bool $own
     * @return array
     */
    public function rules($own = false)
    {
        $rules = [
            'first_name' => 'required|max:127',
            'last_name' => 'max:127',
            'phone_number' => 'required|max:8',
            'address' => 'max:255',
            'comment' => 'max:255',
        ];
        if (!$own) {
            $rules['sucursal_id'] = 'required|integer|min:1';
        }
        return $rules;
    }

}
