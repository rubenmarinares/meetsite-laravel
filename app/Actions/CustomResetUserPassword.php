<?php

namespace App\Actions;

use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class CustomResetUserPassword implements ResetsUserPasswords
{
    /**
     * Resetea la contraseña del usuario.
     */
    public function reset($user, array $input)
    {
         // Validación personalizada
        Validator::make($input, [
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' valida que password_confirmation coincida
        ], [
            'password.required' => 'Debes introducir una contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'La confirmación de la contraseña no coincide',
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }

    /**
     * Ruta de redirección después del reset.
     */
    public function redirectTo()
    {
        // Redirige a login con un mensaje flash
        //$successMessages = ['Contraseña restablecida correctamente.'];
        //session()->flash('success_messages', $successMessages);         
        //return redirect()->route('login');
        return redirect()->route('login')->with('status', '¡Contraseña restablecida correctamente! Por favor, inicia sesión.');
   

    }
}