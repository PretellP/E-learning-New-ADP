<?php

namespace App\Http\Controllers\Aula\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publishing;

class AulaController extends Controller
{
    public function index()
    {
        $publishings = Publishing::orderBy('publication_time', 'DESC')->get();

        // return view('aula.common.home.home', [
        //     'publishings' => $publishings
        // ]);
        return view('aula2.common.home.home', [
            'publishings' => $publishings
        ]);
    }
}
