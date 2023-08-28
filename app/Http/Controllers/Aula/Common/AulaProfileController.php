<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AulaProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('aula.common.profile.index', [
            'user' => $user
        ]);
    }
}
