<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeAboutController extends Controller
{
    //

    public function index()
    {
        $instructors = User::where('role', 'instructor')
                    ->where('active', 'S')
                    ->with(['file' => fn($q) =>
                            $q->where('category', 'avatars')
                    ])->get();
        return view('home.about.index', compact('instructors'));
    }


}
