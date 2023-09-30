<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{CourseSection, SectionChapter};
use App\Services\{FreeCourseService, SectionChapterService};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;

class AdminSectionChaptersController extends Controller
{
    private $sectionChapterService;

    public function __construct(SectionChapterService $service)
    {
        $this->sectionChapterService = $service;
    }

    public function getDataTable(Request $request, CourseSection $section)
    {
        if ($request->ajax()) {

            if ($request['type'] == 'html') {

                $html = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

                return response()->json([
                    "html" => $html,
                    'title' => $section->title,
                ]);
            } elseif ($request['type'] == 'table') {
                return $this->sectionChapterService->getDataTable($section->id);
            }
        }
        abort(403);
    }

    public function getVideoData(SectionChapter $chapter)
    {
        $url_video = verifyFile($chapter->file);

        return response()->json([
            "url_video" => $url_video,
            "section" => $chapter->courseSection->title,
            "chapter" => $chapter->title
        ]);
    }

    public function store(FreeCourseService $freeCourseService, Request $request, CourseSection $section)
    {
        $success = true;
        $htmlCourse = null;
        $htmlSection = null;
        $htmlChapter = null;

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->sectionChapterService->store($request, $section, $storage);
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                ->where('id', $section->course_id)
                ->first();

            $sectionActive = getActiveSection($request['sectionActive']);

            $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
            $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
            $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "htmlChapter" => $htmlChapter,
            "id" => $section->id,
        ]);
    }

    public function edit(SectionChapter $chapter)
    {
        $chaptersList = SectionChapter::where('section_id', $chapter->section_id)
            ->orderBy('chapter_order', 'ASC')
            ->get(['id', 'section_id', 'chapter_order']);

        return response()->json([
            "chapter" => $chapter,
            "chapters_list" => $chaptersList
        ]);
    }

    public function update(FreeCourseService $freeCourseService, Request $request, SectionChapter $chapter)
    {
        $chapter->loadRelationships();

        $success = true;
        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->sectionChapterService->update($request, $chapter, $storage);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $section = $chapter->courseSection;

            $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                ->where('id', $section->course_id)
                ->first();

            $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
            $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlChapter" => $htmlChapter,
            "htmlCourse" => $htmlCourse,
            "id" => $section->id
        ]);
    }


    public function destroy(FreeCourseService $freeCourseService, Request $request, SectionChapter $chapter)
    {
        $chapter->loadRelationships();

        $section = $chapter->courseSection;
        $success = true;
        $htmlCourse = null;
        $htmlSection = null;
        $htmlChapter = null;

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->sectionChapterService->destroy($chapter, $storage);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                ->where('id', $section->course_id)
                ->first();

            $sectionActive = getActiveSection($request['id']);

            $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
            $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
            $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "htmlChapter" => $htmlChapter,
            "id" => $section->id
        ]);
    }
}
