<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User, Company, Course, Event};
use App\Services\DashboardService;
use Carbon\Carbon;

class AdminController extends Controller
{

    private $dashboardService;

    public function __construct(DashboardService $service)
    {
        $this->dashboardService = $service;
    }


    public function index()
    {

        // * cantidad totales

        $users = User::count();
        $company = Company::count();

        $courseRegular = Course::where('course_type', 'REGULAR')->count();
        $courseFree = Course::where('course_type', 'FREE')->count();

        $events = Event::count();

        $approvedSuspended = $this->dashboardService->getStatusEvaluations();

        $approved = $approvedSuspended['approved'];
        $suspended = $approvedSuspended['suspended'];


        $typesOfUsers = $this->dashboardService->getTypeRole();


        return view('admin.common.home.home',[
            'users' => $users,
            'company' => $company,
            'courseRegular' => $courseRegular,
            'courseFree' => $courseFree,
            'events' => $events,
            'approved' => $approved,
            'suspended' => $suspended,
            'typesOfUsers' => $typesOfUsers,
        ]);


    }
}
