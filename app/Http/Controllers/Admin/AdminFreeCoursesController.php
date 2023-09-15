<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Models\{CourseCategory, Course};

class AdminFreeCoursesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $allCourses = DataTables::of(Course::with(['courseCategory',
                                                        'courseSections.sectionChapters'
                                                ])
                                                ->where('course_type', 'FREE'))
                                    ->editColumn('description', function($course){
                                        return '<a href="">'.$course->description.'</a>';
                                    })
                                    ->editColumn('course_category.description', function($course){
                                        return '<a href="">'.$course->courseCategory->description.'</a>';
                                    })
                                    ->addColumn('sections', function($course){
                                        return $course->courseSections->count();
                                    })
                                    ->addColumn('chapters', function($course){
                                        return $course->courseSections->sum(function($section){
                                            return $section->sectionChapters->count();
                                        });
                                    })
                                    ->addColumn('duration', function($course){
                                        return getFreeCourseTime($course);
                                    })
                                    ->editColumn('active', function($course){
                                        $status = $course->active == 'S' ? 'active' : 'inactive';
                                        $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                                        $statusBtn = '<span class="status '.$status.'">'.$txtBtn.'</span>';
                    
                                        return $statusBtn;
                                    })  
                                    ->addcolumn('recom', function($course){
                                        $recomBtn = $course->flg_recom == 1 ? 
                                                    '<i class="fa-solid fa-star flg-recom-btn active"></i>' : 
                                                    '<i class="fa-regular fa-star flg-recom-btn"></i>';

                                        return $recomBtn;
                                    })
                                    ->rawColumns(['description', 'course_category.description', 'active','recom'])
                                    ->make(true);

            return $allCourses;

        }else{
            $categories = CourseCategory::with('courses')->get();

            return view('admin.free-courses.index', [
                'categories' => $categories
            ]);
        }
    }

    public function storeCategory(Request $request)
    {
        $status = $request['categoryStatusCheckbox'] == 'on' ? 'S' : 'N';

        if($request->hasFile('categoryImageRegister'))
        {
            $path = 'img/freecourses/categories/';
            $file = $request->file('categoryImageRegister');
            $uuid = $file->hashName();
            $storeUrl = $path.$uuid;

            Storage::putFileAs($path, $file, $uuid);
        }

        CourseCategory::create([
            "description" => $request['name'],
            "url_img" => $storeUrl,
            "status" => $status
        ]);

        $categories = CourseCategory::with('courses')->get();

        $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function getDataCategory(CourseCategory $category)
    {   
        $url_img = asset('storage/'.$category->url_img);

        return response()->json([
            'description' => $category->description,
            'status' => $category->status,
            'url_img' => $url_img
        ]);
    }

    public function updateCategory(Request $request, CourseCategory $category)
    {
        $status = $request['categoryStatusCheckbox'] == 'on' ? 'S' : 'N';

        if($request->hasFile('categoryImageEdit')){
            $path = 'img/freecourses/categories/';
            $file_path = $category->url_img;
            if($category->url_img != null && Storage::exists($file_path)){
                Storage::delete($file_path);
            }
            $file = $request->file('categoryImageEdit');
            $uuid = $file->hashName();
            $store_url = $path.$uuid;

            Storage::putFileAs($path, $file, $uuid);
            $url_img = $store_url;

        }else{
            $url_img = $category->url_img;
        }

        $category->update([
            "description" => $request['name'],
            "url_img" => $url_img,
            "status" => $status
        ]);

        $categories = CourseCategory::with('courses')->get();
        $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

        return response()->json([
            'html' => $html
        ]);
    }   

    public function destroyCategory(CourseCategory $category)
    {
        $img_path = $category->url_img;
        Storage::delete($img_path);
        $category->delete();

        $categories = CourseCategory::with('courses')->get();
        $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }



    public function getCategoriesRegisterCourse()
    {
        return response()->json([
            "categories" => CourseCategory::all()
        ]);
    }


}
