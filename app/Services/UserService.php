<?php

namespace App\Services;

use App\Role;
use App\User;
use Carbon\Carbon;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserService
{

    /**
     * @var string
     */
    private $defaultAvatar = 'user.png';

    /**
     * Url base para acceder a las fotos a través de http, relativo al directorio publico
     * @var string
     */
    private $avatarUrl = '/storage/photos/';

    /**
     * Ruta donde se almacenan las photos, relativo al directorio de almacenamiento publico
     * /storage/app/public/
     * @var string
     */
    private $avatarPath = 'photos';

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
     * @param UploadedFile $file
     * @param User $user
     */
    public function storageAvatar(UploadedFile $file, User $user)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $user->id . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        Storage::disk('public')->putFileAs($this->avatarPath, $file, $filename);
        $user->photo ? Storage::disk('public')->delete($this->avatarPath . '/' . $user->photo) : null;
        $user->photo = $filename;
        $user->save();
    }

    /**
     * Enviar link para reestablecer la contraseña
     * @param CanResetPassword $user
     */
    public function sendResetLink(CanResetPassword $user)
    {
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

}