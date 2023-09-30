<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;

use App\Models\{CourseCategory, Course, SectionChapter};
use App\Services\{CourseCategoryService, FreeCourseService};
use Exception;

class AdminFreeCoursesController extends Controller
{
    private $freeCourseService;

    public function __construct(FreeCourseService $service)
    {
        $this->freeCourseService = $service;
    }

    public function index(CourseCategoryService $courseCategoryService, Request $request)
    {
        if ($request->ajax()) {
            return $this->freeCourseService->getCoursesDataTable();
        }

        $categories = $courseCategoryService->withCategoryRelationshipsQuery()->get();

        return view('admin.free-courses.index', [
            'categories' => $categories
        ]);
    }

    public function getCategoriesRegisterCourse()
    {
        return response()->json([
            "categories" => CourseCategory::all()
        ]);
    }


    public function store(Request $request)   // FALTA
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        $path = 'img/freecourses/';
        $file = $request->file('courseImageRegister');
        $uuid = $file->hashName();
        $storeUrl = $path . $uuid;


        if ($request->has('fixedCategory')) {
            $category = $request['fixedCategory'];
        } else {
            $category = $request['category'];
        }

        $course = Course::create([
            "course_type" => 'FREE',
            "category_id" => $category,
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "date" => getCurrentDate(),
            "hours" => 0,
            "time_start" => '0:00:00',
            "time_end" => '0:00:00',
            "url_img" => $storeUrl,
            "active" => $status,
            "flg_recom" => $recom,
            'flg_public' => 'N'
        ]);

        if ($course) {
            Storage::putFileAs($path, $file, $uuid);
        }

        if ($request['verifybtn'] == 'show') {
            $route = route('admin.freeCourses.courses.index', $course);

            return response()->json([
                "show" => true,
                "route" => $route
            ]);
        } else {
            if ($request->has('fixedCategory')) {
                $category = CourseCategory::where('id', $category)->with('courses')->first();
                $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            } else {
                $categories = CourseCategory::with('courses')->get();
                $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();
            }

            return response()->json([
                "show" => false,
                "success" => true,
                "html" => $html
            ]);
        }
    }

    public function show(Course $course)
    {
        $course->loadFreeCourseRelationships();

        $sectionActive = '';

        return view('admin.free-courses.courses.index', [
            'course' => $course,
            'sectionActive' => $sectionActive
        ]);
    }

    public function edit(Course $course)
    {
        $course->loadFreeCourseImage();

        $url_img = verifyImage($course->file);

        return response()->json([
            "description" => $course->description,
            "subtitle" => $course->subtitle,
            "status" => $course->active,
            "recom" => $course->flg_recom,
            "url_img" => $url_img
        ]);
    }

    public function update(Request $request, Course $course)  // FALTA
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        $course->loadFreeCourseRelationships();

        $this->freeCourseService->updateCourse($request, $course); // FALTA

        if ($request->hasFile('courseImageEdit')) {
            $path = 'img/freecourses/';
            $file_path = $course->url_img;
            if ($course->url_img != null && Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $file = $request->file('courseImageEdit');
            $uuid = $file->hashName();
            $store_url = $path . $uuid;

            Storage::putFileAs($path, $file, $uuid);
            $url_img = $store_url;
        } else {
            $url_img = $course->url_img;
        }

        $course->update([
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "url_img" => $url_img,
            "active" => $status,
            "flg_recom" => $recom
        ]);

        $html = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $description = mb_strtolower($course->description, 'UTF-8');

        return response()->json([
            "success" => true,
            "description" => $description,
            "html" => $html
        ]);
    }

    public function destroy(Course $course) // FALTA
    {
        $img_path = $course->url_img;
        Storage::delete($img_path);
        $course->delete();

        $category = $course->courseCategory;

        return response()->json([
            "route" => route('admin.freeCourses.categories.index', $category)
        ]);
    }
}
