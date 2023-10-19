<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{Company, MiningUnit, User};
use App\Services\Home\{HomeCourseService};
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $courseService;
    private $userService;

    public function __construct(HomeCourseService $courseService, UserService $userService)
    {
        $this->courseService = $courseService;
        $this->userService = $userService;
    }


    public function index(Request $request)
    {
        $courses = $this->courseService->getAvailableCourses();
        $instructors = User::where('role', 'instructor')
                            ->where('active', 'S')
                            ->with(['file' => fn($q) => 
                                    $q->where('category', 'avatars')
                            ])->get();

        return view('home.home', compact(
            'courses',
            'instructors',
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
