<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminFreeCoursesController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.free-courses.index');
    }
}
