<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use App\Services\{CourseService, FreeCourseService};
use Auth;

class AulaMyProgressController extends Controller
{
    public function index(FreeCourseService $freeCourseService, CourseService $courseService)
    {
        $user = Auth::user();

        $courses = $courseService->getCoursesBasedOnRole($user);

        $freeCourses = $freeCourseService->withFreeCourseRelationshipsQuery()
                                        ->where('active', 'S')
                                        ->with('courseChapters.progressUsers')
                                        ->whereHas('courseChapters.progressUsers', function($query) use ($user) {
                                            $query->where('user_id', $user->id);
                                        })
                                        ->get();
                            
        return view('aula.viewParticipant.myprogress.index', [
            'courses' => $courses,
            'freeCourses' => $freeCourses,
        ]);
    }
}
