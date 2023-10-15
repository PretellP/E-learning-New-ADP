<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{Company, MiningUnit};
use App\Services\Home\{HomeCourseService};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $courseService;

    public function __construct(HomeCourseService $service)
    {
        $this->courseService = $service;
    }

    public function index(Request $request)
    {
        $courses = $this->courseService->getAvailableCourses();

        return view('home.home', compact(
            'courses'
        ));
    }

    public function getRegisterModalContent()
    {
        $miningUnits = MiningUnit::get(['id', 'description']);
        $companies = Company::where('active', 'S')->get(['id', 'description']);

        return response()->json([
            "html" => view('home.common.partials.boxes._login_register', compact(
                'miningUnits',
                'companies'
            ))->render()
        ]);
    }
}
