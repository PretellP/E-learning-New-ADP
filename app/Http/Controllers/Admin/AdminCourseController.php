<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Course};
use App\Services\{CourseService};
use Exception;

class AdminCourseController extends Controller
{
    private $courseService;

    public function __construct(CourseService $service)
    {
        $this->courseService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->courseService->getDataTable();
        }
        return view('admin.courses.index');
    }

    public function store(CourseRequest $request)
    {
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseService->store($request, $storage);
        }catch(Exception $e){
            abort(500, $e->getMessage());
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function edit(Course $course)
    {
        $course->loadCourseImage();

        $url_img = verifyImage($course->file);

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

    public function update(CourseRequest $request, Course $course)
    {
        $course->loadCourseImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseService->update($request, $storage, $course);
        }catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function destroy(Course $course)
    {
        $course->loadCourseImage();
        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->courseService->destroy($storage, $course);
        }catch(Exception $e){
            abort(500, $e->getMessage());
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function show(Course $course)
    {
        $course->loadMissing(
            [
                'file' => fn ($query) =>
                $query->where('file_type', 'imagenes')
                    ->where('category', 'cursos'),

                'folders' => fn ($query2) =>
                $query2->where('level', 1)
            ],
        );

        $folders = $course->folders;

        return view('admin.courses.show', [
            'course' => $course,
            'folders' => $folders
        ]);
    }
}
