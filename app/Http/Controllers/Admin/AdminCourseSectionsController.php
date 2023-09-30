<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSectionRequest;
use Illuminate\Http\Request;
use App\Models\{Course, CourseSection};
use App\Services\{CourseSectionService, FreeCourseService};
use Exception;
use Laravel\Ui\Presets\React;

class AdminCourseSectionsController extends Controller
{
    private $courseSectionService;

    public function __construct(CourseSectionService $service)
    {
        $this->courseSectionService = $service;
    }

    public function store(Request $request, Course $course)
    {
        parse_str($request['form'], $form);

        $success = true;
        $message = null;
        $htmlCourse = null;
        $htmlCourse = null;

        try{
            $this->courseSectionService->store($form, $course);
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($success)
        {
            $course->loadFreeCourseRelationships();
            $sectionActive = getActiveSection($request['id']);
    
            $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
            $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
        }
      
        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection
        ]);
    }

    public function edit(CourseSection $section)
    {
        $sections = CourseSection::where('course_id', $section->course_id)
                    ->orderBy('section_order', 'ASC')
                    ->get(['id', 'section_order', 'course_id']);

        return response()->json([
            "title" => $section->title,
            "sections" => $sections,
            'order' => $section->section_order
        ]);
    }

    public function updateOrder(Request $request, CourseSection $section)
    {
        $order = $request['value'];

        $this->courseSectionService->updateOrder($order, $section);

        $course = $section->course->loadFreeCourseRelationships();

        $sectionActive = getActiveSection($request['id']);
        $html = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "html" => $html
        ]);
    }

    public function update(Request $request, CourseSection $section) 
    {
        parse_str($request['form'], $form);

        $success = true;
        $message = null;
        $sectionActive = null;
        $htmlSection = null;

        try{
            $this->courseSectionService->update($form, $section);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $course = $section->course->loadFreeCourseRelationships();
        
        $sectionActive = getActiveSection($request['id']);

        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlSection" => $htmlSection,
            "active" => $sectionActive,
            "id" => $section->id,
            "title" => $section->title
        ]);
    }

    public function destroy(FreeCourseService $freeCourseService, Request $request, CourseSection $section) // FALTA
    {
        $course_id = $section->course_id;

        $success = true;
        $is_active = 0;
        $htmlChapter = '';

        try{
            $this->courseSectionService->destroy($section);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $course_id)
                                            ->first();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        if ($request['active'] == 'active') {
            $htmlChapter  = view('admin.free-courses.partials.chapter-list-empty')->render();
            $is_active = 1;
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "is_active" => $is_active,
            "htmlChapter" => $htmlChapter
        ]);
    }
}
