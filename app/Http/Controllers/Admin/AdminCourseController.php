<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\{Course, Folder};

class AdminCourseController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $allCourses = DataTables::of(Course::query()
                                            ->with(['folders:id,id_course',
                                                    'exams:id,course_id',
                                            ])->where('course_type', 'REGULAR')
                                )
                                ->addColumn('description', function($course){
                                    return '<a href="'.route('admin.courses.show', $course).'" class="content-course-btn">'.$course->description.'</a>';
                                })
                                ->addColumn('time_start', function($course){
                                    return (Carbon::parse($course->time_start))->format('g:i A');
                                })
                                ->addColumn('time_end', function($course){
                                    return (Carbon::parse($course->time_end))->format('g:i A');
                                })
                                ->addColumn('status', function($course){
                                    $status = $course->active == 'S' ? 'active' : 'inactive';
                                    $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                                    $statusBtn = '<span class="status '.$status.'">'.$txtBtn.'</span>';
                
                                    return $statusBtn;
                                })
                                ->addColumn('action', function($course){
                                    $btn = '<button data-toggle="modal" data-id="'.
                                            $course->id.'" data-url="'.route('admin.courses.update', $course).'" 
                                            data-send="'.route('admin.courses.edit', $course).'"
                                            data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                            editCourse"><i class="fa-solid fa-pen-to-square"></i></button>';
                                    if($course->exams->isEmpty() &&
                                        $course->folders->isEmpty())
                                    {
                                        $btn.= '<a href="javascript:void(0)" data-id="'.
                                                $course->id.'" data-original-title="delete"
                                                data-url="'.route('admin.courses.delete', $course).'" class="ms-3 edit btn btn-danger btn-sm
                                                deleteCourse"><i class="fa-solid fa-trash-can"></i></a>';
                                    }
                                
                                    return $btn;
                                })
                                ->rawColumns(['description','status','action'])
                                ->make(true);

            return $allCourses;
        }
        return view('admin.courses.index');
    }   

    public function store(Request $request)
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';
        $storeUrl = 'img/courses/default.jpg';

        if($request->hasFile('courseImageRegister'))
        {
            $path = 'img/courses/';
            $file = $request->file('courseImageRegister');
            $uuid = $file->hashName();
            $storeUrl = $path.$uuid;

            Storage::putFileAs($path, $file, $uuid);
        }

        $timeStart = Carbon::parse(Carbon::createFromFormat('g:i A', $request['timeStart']))->format('h:i:s');
        $timeEnd = Carbon::parse(Carbon::createFromFormat('g:i A', $request['timeEnd']))->format('h:i:s');

        Course::create([
            "course_type" => 'REGULAR',
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "date" => $request['date'],
            "hours" => $request['hours'],
            "time_start" => $timeStart,
            "time_end" => $timeEnd,
            "url_img" => $storeUrl,
            "active" => $status
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function edit(Course $course)
    {
        $url_img = asset('storage/'.$course->url_img);

        return response()->json([
            "id" => $course->id,
            "name" => $course->description,
            "subtitle" => $course->subtitle,
            "date" => $course->date,
            "hours" => $course->hours,
            "time_start" => (Carbon::parse($course->time_start))->format('g:i A'),
            "time_end" => (Carbon::parse($course->time_end))->format('g:i A'),
            "url_img" => $url_img,
            "status" => $course->active
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $status = $request['courseStatusCheckbox'] == 'on' ? 'S' : 'N';

        if($request->hasFile('courseImageEdit')){
            $path = 'img/courses/';
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

        $timeStart = Carbon::parse(Carbon::createFromFormat('g:i A', $request['timeStart']))->format('h:i:s');
        $timeEnd = Carbon::parse(Carbon::createFromFormat('g:i A', $request['timeEnd']))->format('h:i:s');

        $course->update([
            "description" => $request['name'],
            "subtitle" => $request['subtitle'],
            "date" => $request['date'],
            "hours" => $request['hours'],
            "time_start" => $timeStart,
            "time_end" => $timeEnd,
            "url_img" => $url_img,
            "active" => $status
        ]);

        return response()->json([
            "success" => true
        ]);
    }

    public function destroy(Course $course)
    {
        $img_path = $course->url_img;
        
        if(basename($img_path) != 'default.jpg'){
            Storage::delete($img_path);
        }

        $course->delete();
        
        return response()->json([
            "success" => true
        ]);
    }

    public function show(Course $course)
    {
        $folders = $course->folders()->where('level', 1)->get();

        return view('admin.courses.show', [
            'course' => $course,
            'folders' => $folders
        ]);
    }

  



}
