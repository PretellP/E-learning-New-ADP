<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Services\CourseCategoryService;
use App\Services\FreeCourseService;
use Illuminate\Http\Request;

class HomeFreeCourseController extends Controller
{
    public function index()
    {
        $categories = app(CourseCategoryService::class)->withCategoryRelationshipsQuery()
                    ->where('status', 'S')
                    ->get();

        return view('home.freecourses.index', compact(
            'categories'
        ));
    }

    public function show(CourseCategory $category)
    {
        $freeCourses = app(FreeCourseService::class)->withFreeCourseRelationshipsQuery()
                        ->where('active', 'S')
                        ->where('category_id', $category->id)
                        ->having('course_chapters_count', '>', 0)
                        ->get();

        return view('home.freecourses.show', compact(
            'freeCourses',
            'category'
        ));
    }
}
