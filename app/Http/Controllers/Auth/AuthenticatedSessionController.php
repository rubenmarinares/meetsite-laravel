<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;








class AuthenticatedSessionController extends Controller
{


        public function store(LoginRequest $request): RedirectResponse
        {

            $credentials = $request->only('email', 'password');

            if (! Auth::attempt($credentials, $request->boolean('remember'))) {
                //echo "CREDENCIALES INCORRECTAS";

                $successMessages = [            
                    'Credenciales correctas.'
                ];        
                //session()->flash('success_messages', [auth.failed]);
                session()->flash('error_messages', [trans('auth.failed')]);
                return back();
            }

            $request->session()->regenerate();
            $user = Auth::user();

            $academias = $user->academias();
            session()->put('user_academias', $academias);            

              $successMessages = [            
                'Credenciales correctas.'
            ];        
            session()->flash('success_messages', $successMessages);

            return redirect()->route('home');
        }

}
