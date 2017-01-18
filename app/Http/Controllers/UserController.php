<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

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
    public function show($id=null)
    {
        if ($id&&$user = User::find($id)) {
            return view('user.show', ['user' => $user]);
        }else if(!$id){
            return view('user.show', ['user' => Auth::user()]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para editar un usuario
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if($user=User::find($id)){
            return view('user.edit',['user'=>$user]);
        }
        return response()->view('errors.404',[],404);
    }

    /**
     * Almacena la informacion de un usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        return redirect('usuarios');
    }

}
