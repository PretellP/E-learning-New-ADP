<?php

namespace App\Services;

use App\Mail\UserCredentialsMessage;
use App\Models\{User};
use Exception;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendUserCredentialsMail(User $user, $password)
    {
       return  Mail::to($user->email)
                ->send(new UserCredentialsMessage($user, $password));
    }
}