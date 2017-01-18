<?php

namespace App\Services;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserService
{

    /**
     * Almacena los datos del usuario detallados en la petición
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('nombrepersona')." ".$request->input('apellidopersona');
        $email = $request->input('email');
        $password = $request->input('password');
        if ($user = User::find($id)) {
            $user->update([
                'name' => $name,
                'email' => $email,
            ]);
        } else {
            $this->validator($request->all())->validate();
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
        }
        if ($roles = $request->input('roles')) {
            $this->assignRoles($roles, $user);
        }
        return $user->id;
    }

    /**
     * Asigna roles al usuario especificado
     * @param $roles
     * @param User $user
     */
    public function assignRoles($roles, User $user)
    {
        $this->removeRoles($user);
        foreach ($roles as $id) {
            $rol = Role::find($id);
            if (!$user->hasRole($rol->name)) {
                $user->attachRole($rol);
            }
        }
    }

    /**
     * Remueve todos los roles del usuario especificado
     * Es más eficiente que el método proporcionado por Entrust
     * @param User $user
     */
    public function removeRoles(User $user)
    {
        DB::table('role_user')->where('user_id', $user->id)->delete();
    }

    /**
     * Almacena la foto del usuario como un archivo imagen
     * @param Request $request
     * @param bool $new
     * @return string | null
     */
    public function storageAvatar(Request $request, $new = false)
    {
        if (!$this->persona) {
            $this->persona = $this->personaService->findById('id', Auth::id());
        }
        $destinationPath = public_path() . $this->pathavatar;
        $filename = $this->defaultavatar;
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $foto = $request->file('avatar');
            $extension = $foto->getClientOriginalExtension();
            $filename = Auth::id().'-' .Uuid::uuid4(). '.' . $extension;
            $foto->move($destinationPath, $filename);
            $this->persona->setFotopersona($filename);
        } else if ($new) {
            $this->persona->setFotopersona($filename);
        }
        return $filename;
    }

    /**
     * Cambia o actualizar la foto
     * @param Request $request
     * @return mixed
     */
    public function changeAvatar(Request $request)
    {
        $filename = $this->storageAvatar($request);
        $this->personaService->updatewoa($this->persona);
        return url($this->pathavatar . $filename);
    }


    /**
     * Get a validator for an incoming registration request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::setPresenceVerifier(\App::make('eloquent.validation.presence'));

        return Validator::make($data, [
            'nombrepersona' => 'required|max:255',
            'apellidopersona' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

}