<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Auth;

class AulaCourseController extends Controller
{
    public function index(CourseService $courseService)
    {
        $user = Auth::user();
        $courses = $courseService->getCoursesBasedOnRole($user);

        return view('aula.common.courses.index', [
            'courses' => $courses,
        ]);
    }
}
