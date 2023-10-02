<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

use App\Models\{CourseCategory};
use App\Services\{CourseCategoryService, FreeCourseService};
use Exception;

class AdminCourseCategoriesController extends Controller
{
    private $courseCategoryService;

    public function __construct(CourseCategoryService $service)
    {
        $this->courseCategoryService = $service;
    }

    public function index(Request $request, CourseCategory $category)
    {
        if ($request->ajax()) {
            return app(FreeCourseService::class)->getCoursesDataTable($category->id);
        }

        $category->loadImage();

        return view('admin.free-courses.categories.index', [
            'category' => $category,
        ]);
    }


    public function edit(CourseCategory $category)
    {
        $category->loadImage();
        $url_img = verifyImage($category->file);

        return response()->json([
            "description" => $category->description,
            "status" => $category->status,
            "url_img" => $url_img
        ]);
    }


    public function store(CategoryRequest $request) 
    {
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseCategoryService->store($request, $storage);
            
            $categories = $this->courseCategoryService->withCategoryRelationshipsQuery()->get();

            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

        }catch(Exception $e){
            abort(500, $e->getMessage());
        }

        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }


    public function update(CategoryRequest $request, CourseCategory $category)
    {
        $category->loadImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseCategoryService->update($request, $storage, $category);
        }catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($request['place'] == 'show') {
            $category->loadImage();
            $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            return response()->json([
                'html' => $html,
                'description' => mb_strtolower($category->description, 'UTF-8')
            ]);
        } else {
            $categories = CourseCategory::with(['courses', 'file'])->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

            return response()->json([
                'html' => $html
            ]);
        }
    }


    public function destroy(Request $request, CourseCategory $category)
    {
        $category->loadImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseCategoryService->destroy($storage, $category);
        }catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($request->has('place')) {
            return response()->json([
                "route" => route('admin.freeCourses.index')
            ]);
        } else {
            $categories = CourseCategory::with(['courses', 'file'])->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }
}
