<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Course, CourseSection};
use App\Services\{CourseSectionService, FreeCourseService};
use Exception;


class AdminCourseSectionsController extends Controller
{
    private $courseSectionService;

    public function __construct(CourseSectionService $service)
    {
        $this->courseSectionService = $service;
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

    public function store(Request $request, Course $course) // FALTA
    {
        parse_str($request['form'], $form);

        $course->loadMax('courseSections', 'section_order'); 

        $lastOrder = $course->course_sections_max_section_order == null ?
                    0 : $course->course_sections_max_section_order;

        $section = CourseSection::create([
            "title" => $form['title'],
            "section_order" => $lastOrder + 1,
            "course_id" => $course->id
        ]);

        $course->loadFreeCourseRelationships();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection
        ]);
    }

    public function updateOrder(Request $request, CourseSection $section) // FALTA
    {
        $order = $request['value'];

        if ($section->section_order != $order) {

            CourseSection::where('course_id', $section->course_id)
                ->where('section_order', $order)
                ->update([
                    "section_order" => $section->section_order
                ]);

            $section->update([
                "section_order" => $order
            ]);
        }

        $course = $section->course->loadFreeCourseRelationships();

        $sectionActive = getActiveSection($request['id']);

        $html = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "html" => $html
        ]);
    }

    public function update(Request $request, CourseSection $section) // FALTA
    {
        parse_str($request['form'], $form);

        if ($section->section_order != $form['order']) {
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

        $course = $section->course->loadFreeCourseRelationships();
        
        $sectionActive = getActiveSection($request['id']);

        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();

        return response()->json([
            "htmlSection" => $htmlSection,
            "active" => $sectionActive,
            "id" => $section->id,
            "title" => $section->title
        ]);
    }

    public function destroy(FreeCourseService $freeCourseService, Request $request, CourseSection $section) // FALTA
    {
        $course_id = $section->course_id;
        $section->delete();

        $sections = CourseSection::where('course_id', $course_id)
                    ->orderBy('section_order', 'ASC')->get();

        $order = 1;
        foreach ($sections as $section) {
            $section->update([
                "section_order" => $order
            ]);
            $order++;
        }

        $is_active = 0;
        $htmlChapter = '';

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
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "is_active" => $is_active,
            "htmlChapter" => $htmlChapter
        ]);
    }
}
