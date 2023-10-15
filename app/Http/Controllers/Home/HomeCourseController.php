<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{Company, Course, MiningUnit};
use App\Services\Home\{HomeCourseService};
use Illuminate\Http\Request;

class HomeCourseController extends Controller
{
    private $courseService;

    public function __construct(HomeCourseService $service)
    {
        $this->courseService = $service;
    }
    
    public function index() 
    {
        $courses = $this->courseService->getAvailableCourses();

        return view('home.courses.index', compact(
            'courses'
        ));
    }

    public function show(Course $course)
    {
        $events = $this->courseService->getAvailableEvents($course);

        $miningUnits = MiningUnit::get(['id', 'description']);
        $companies = Company::where('active', 'S')->get(['id', 'description']);

        return view('home.courses.show', compact(
            'course',
            'events',
            'companies',
            'miningUnits'
        ));
    }
}
