<?php

namespace App\Http\Controllers;

use App\Role;
use App\Services\UserService;
use App\Sucursal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jleon\LaravelPnotify\Notify;
use Ramsey\Uuid\Uuid;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
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
        $id ? null : $id = Auth::id();
        if ($user = User::find($id)) {
            return view('user.edit', [
                'user' => $user,
                'sucursales' => Sucursal::all(),
                'roles' => Role::all(),
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la informacion de un usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if ($request->id && $user = User::find($request->id)) {
            $user->update($request->except(['id', '_token']));
        } else {
            $aleat=Uuid::uuid4();
            $request->merge(['password'=>$aleat,'password_confirmation'=>$aleat]);
            $this->userService->validator($request->all())->validate();
            $user = User::create($request->except(['id', '_token']));
            $this->userService->sendResetLink($user);
        }
        if ($roles = $request->input('roles')) {
            $this->userService->assignRoles($roles, $user);
        }
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $this->userService->storageAvatar($request->file('avatar'), $user);
        }
        return redirect()->action('UserController@show',['id'=>$user->id]);
    }

    /**
     * Deshabilita el usuario espeficado
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        if ($request->user_id) {
            if($this->userService->disable($request->user_id)){
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
            if($this->userService->enable($request->user_id)){
                Notify::success('Se habilitó al usuario');
                return redirect()->back();
            }
        }
        Notify::warning('No se habilitó al usuario');
        return redirect()->back();
    }

}
