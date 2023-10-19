<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{Company, MiningUnit, User};
use App\Services\Home\{HomeCourseService};
use App\Services\{CourseCategoryService};
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $courses = app(HomeCourseService::class)->getAvailableCourses();
        $instructors = User::where('role', 'instructor')
                            ->where('active', 'S')
                            ->with(['file' => fn($q) => 
                                    $q->where('category', 'avatars')
                            ])->get();

        $categories = app(CourseCategoryService::class)->withCategoryRelationshipsQuery()
                                                        ->where('status', 'S')
                                                        ->get();

        return view('home.home', compact(
            'courses',
            'instructors',
            'categories',
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
