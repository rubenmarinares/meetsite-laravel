<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        $toEmail = "rubenmarinares@gmail.com"; 
        $subject = "Correo de prueba Laravel";
        $message = "¡Hola! 🚀 Este es un correo de prueba enviado desde Laravel usando SMTP.";

        Mail::raw($message, function ($msg) use ($toEmail, $subject) {
            $msg->to($toEmail)->subject($subject);
        });

        return "Correo enviado correctamente a {$toEmail}";
    }
}