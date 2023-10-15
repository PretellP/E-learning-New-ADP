<?php

namespace App\Services\Home;
use App\Models\{Event};
use App\Services\Auth\AuthService;
use App\Services\CertificationService;
use Auth;
use Illuminate\Http\Request;

class HomeCertificationService
{
    public function userSelfRegisterCertification(Request $request, Event $event)
    {
        $user = Auth::user();

        if(app(AuthService::class)->validateUserCredentials($request))
        {
            return app(CertificationService::class)->selfStore($user, $event);
        }

        return false;
    }
}