<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Models\{CourseCategory, Course, CourseSection, SectionChapter};

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
                                        return '<a href="'.route('admin.freeCourses.courses.index', $course).'">'.$course->description.'</a>';
                                    })
                                    ->editColumn('course_category.description', function($course){
                                        $category = $course->courseCategory;
                                        return '<a href="'.route('admin.freeCourses.categories.index', $category).'">'.$course->courseCategory->description.'</a>';
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

        if($request['place'] == 'show'){

            $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            return response()->json([
                'html' => $html,
                'description' => mb_strtolower($category->description, 'UTF-8')
            ]);

        }else{
            $categories = CourseCategory::with('courses')->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();
    
            return response()->json([
                'html' => $html
            ]);
        }
    }   

    public function destroyCategory(Request $request, CourseCategory $category)
    {
        $img_path = $category->url_img;
        Storage::delete($img_path);
        $category->delete();

        if($request->has('place')){

            return response()->json([
                "route" => route('admin.freeCourses.index')
            ]);

        }else{
            $categories = CourseCategory::with('courses')->get();
            $html = view('admin.free-courses.partials.categories-list', compact('categories'))->render();
    
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
    }

    public function getCategoriesRegisterCourse()
    {
        return response()->json([
            "categories" => CourseCategory::all()
        ]);
    }

    public function storeFreecourse(Request $request)
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        $path = 'img/freecourses/';
        $file = $request->file('courseImageRegister');
        $uuid = $file->hashName();
        $storeUrl = $path.$uuid;

    
        if($request->has('fixedCategory')){
            $category = $request['fixedCategory'];
        }else{
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

        if($course){
            Storage::putFileAs($path, $file, $uuid);
        }

        if($request['verifybtn'] == 'show')
        {
            $route = route('admin.freeCourses.courses.index', $course);

            return response()->json([
                "show" => true,
                "route" => $route
            ]);
            
        }else{
            if($request->has('fixedCategory')){
                $category = CourseCategory::where('id', $category)->with('courses')->first();
                $html = view('admin.free-courses.partials.category-box', compact('category'))->render();
            }else{
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



    // ------- CATEGORIES INDEX ----------


    public function showCategory(Request $request, CourseCategory $category)
    {
        if($request->ajax()){
            $allCourses = DataTables::of(Course::with(['courseCategory',
                                                        'courseSections.sectionChapters'
                                                ])
                                                ->where('course_type', 'FREE')
                                                ->where('category_id', $category->id)
                                    )
                                    ->editColumn('description', function($course){
                                        return '<a href="'.route('admin.freeCourses.courses.index', $course).'">'.$course->description.'</a>';
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
                                    ->rawColumns(['description', 'active','recom'])
                                    ->make(true);

            return $allCourses;

        }else{

            return view('admin.free-courses.categories.index', [
                'category' => $category
            ]);
        }

        
    }

    // ---- FREE COURSE INDEX --------------

    public function showCourse(Request $request, Course $course)
    {
        if($request->ajax())
        {

        }else{
            $course = Course::where('id', $course->id)
                        ->with('courseCategory')
                        ->with(['courseSections' => fn($query) =>
                                $query->orderBy('section_order', 'ASC')
                                    ->with(['sectionChapters' => fn($query2) =>
                                        $query2->orderBy('chapter_order', 'ASC')
                                    ])
                        ])
                        ->first();

            $sectionActive = '';

            return view('admin.free-courses.courses.index', [
                'course' => $course,
                'sectionActive' => $sectionActive
            ]);
        }
        
    }

    public function getDataCourse(Course $course)
    {
        $url_img = asset('storage/'.$course->url_img);

        return response()->json([
            "description" => $course->description,
            "subtitle" => $course->subtitle,
            "status" => $course->active,
            "recom" => $course->flg_recom,
            "url_img" => $url_img
        ]);
    }

    public function updateFreecourse(Request $request, Course $course)
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $recom = $request['courseRecomCheckbox'] == 'on' ? 1 : 0;

        if($request->hasFile('courseImageEdit')){
            $path = 'img/freecourses/';
            $file_path = $course->url_img;
            if($course->url_img != null && Storage::exists($file_path)){
                Storage::delete($file_path);
            }
            $file = $request->file('courseImageEdit');
            $uuid = $file->hashName();
            $store_url = $path.$uuid;

            Storage::putFileAs($path, $file, $uuid);
            $url_img = $store_url;

        }else{
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

    public function destroyCouse(Request $request, Course $course)
    {
        if($request['type'] == 'soft')
        {
            $img_path = $course->url_img;
            Storage::delete($img_path);
            $course->delete();
        }

        $category = $course->courseCategory;

        return response()->json([
            "route" => route('admin.freeCourses.categories.index', $category)
        ]);
    }


    public function updateSectionOrder(Request $request, CourseSection $section)
    {
        $order = $request['value'];

        if($section->section_order != $order){

            CourseSection::where('course_id', $section->course_id)
                            ->where('section_order', $order)
                            ->update([
                                "section_order" => $section->section_order
                            ]);

            $section->update([
                "section_order" => $order
            ]);
        }

        $course = $section->course()->with(['courseSections' => function($query){
                                        $query->orderBy('section_order', 'ASC')
                                            ->with('sectionChapters');
                                    }])
                                    ->first();


        $sectionActive = $request['id'] != null ? $request['id'] : '';

        $html = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "html" => $html
        ]);
    }


    public function storeSection(Request $request, Course $course)
    {
        parse_str($request['form'], $form);

        $lastSection = $course->courseSections()
                        ->orderBy('section_order', 'DESC')
                        ->first();
        
        $lastOrder = $lastSection == null ? 0 : $lastSection->section_order;

        $section = CourseSection::create([
                        "title" => $form['title'],
                        "section_order" => $lastOrder+1,
                        "course_id" => $course->id
                    ]);

        $course = $section->course()->with(['courseSections' => function($query){
                                        $query->orderBy('section_order', 'ASC')
                                              ->with('sectionChapters');
                                    }, 'courseCategory'])
                                    ->first();

        $sectionActive = $request['id'] != null ? $request['id'] : '';

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection
        ]);
    }

    public function getDataSection(CourseSection $section)
    {
        $sections = CourseSection::where('course_id', $section->course_id)
                                    ->orderBy('section_order', 'ASC')
                                    ->get(['id','section_order','course_id']);

        return response()->json([
            "title" => $section->title,
            "sections" => $sections,
            'order' => $section->section_order
        ]);
    }

    public function updateSection(Request $request, CourseSection $section)
    {
        parse_str($request['form'], $form);

        if($section->section_order != $form['order']){
            CourseSection::where('course_id', $section->course_id)
                            ->where('section_order', $form['order'])
                            ->update([
                                "section_order" => $section->section_order
                            ]);
        }

        $section->update([
            "title" => $form['title'],
            "section_order" => $form['order'],
        ]);

        $course = $section->course()->with(['courseSections' => function($query){
                                        $query->orderBy('section_order', 'ASC')
                                            ->with('sectionChapters');
                                    }, 'courseCategory'])
                                    ->first();

        $sectionActive = $request['id'] != null ? $request['id'] : '';

        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlSection" => $htmlSection
        ]);

    }


    public function destroySection(Request $request, CourseSection $section)
    {
        $course_id = $section->course_id;
        $section->delete();

        $sections = CourseSection::where('course_id', $course_id)
                                ->orderBy('section_order', 'ASC')->get();

        $order = 1;
        foreach($sections as $section){
            $section->update([
                "section_order" => $order
            ]);
            $order++;
        }

        $is_active = 0;
        $htmlChapter = '';

        $course = Course::where('id', $course_id)->with(['courseSections' => function($query){
                                                    $query->orderBy('section_order', 'ASC')
                                                        ->with('sectionChapters');
                                                }, 'courseCategory'])
                                                ->first();

        $sectionActive = $request['id'] != null ? $request['id'] : '';

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        if($request['active'] == 'active'){
            $htmlChapter  = view('admin.free-courses.partials.chapter-list-empty')->render();
            $is_active = 1;
        }

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "is_active" => $is_active,
            "htmlChapter" => $htmlChapter
        ]);
    }

    public function getChapterTable(Request $request, CourseSection $section)
    {
        if($request->ajax()){

            if($request['type'] == 'html'){

                $html = view('admin.free-courses.partials.chapters-list')->render();

                return response()->json([
                    "html" => $html,
                    'title' => $section->title
                ]);

            }elseif($request['type'] == 'table'){

                $allChapters = DataTables::of(SectionChapter::where('section_id', $section->id)
                                                            ->with('progressUsers')
                                )
                                ->editColumn('duration', function($chapter){
                                    return $chapter->duration.' minutos';
                                })
                                ->editColumn('description', function($chapter){
                                    return mb_substr($chapter->description, 0, 100, 'UTF-8').' ...';
                                })
                                ->addColumn('view', function($chapter){
                                    return ' <a href=""> <i class="fa-solid fa-video"></i> </a>';
                                })
                                ->addColumn('action', function($chapter){
                                    $btn = '<button data-id="'.$chapter->id.'" 
                                            data-url="" 
                                            data-send=""
                                            data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                            editChapter"><i class="fa-solid fa-pen-to-square"></i></button>';
                                    if($chapter->progressUsers->isEmpty())
                                    {
                                        $btn.= '<a href="javascript:void(0)" data-id="'.
                                                $chapter->id.'" data-original-title="delete"
                                                data-url="" class="ms-3 edit btn btn-danger btn-sm
                                                deleteChapter"><i class="fa-solid fa-trash-can"></i></a>';
                                    }
                                
                                    return $btn;
                                })
                                ->rawColumns(['view', 'action'])
                                ->make(true);

                return $allChapters;
            }

        }
    }
}
