<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{CourseSection, SectionChapter};
use App\Services\{FreeCourseService, SectionChapterService};
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
        $url_video = asset('storage/' . $chapter->url_video);

        return response()->json([
            "url_video" => $url_video,
            "section" => $chapter->courseSection->title,
            "chapter" => $chapter->title
        ]);
    }

    public function store(FreeCourseService $freeCourseService, Request $request, CourseSection $section) // FALTA
    {
        $section->loadMax('sectionChapters', 'chapter_order');

        $videoDur = new GetId3($request->file('file'));
        $duration = round($videoDur->getPlaytimeSeconds() / 60);

        $path = 'videos/freecourses/' . $section->course_id . '/' . $section->id . '/';
        $video = $request->file('file');
        $uuid = $video->hashName();
        $storeUrl = $path . $uuid;

        $lastOrder = $section->section_chapters_max_chapter_order == null ? 0 :
                                $section->section_chapters_max_chapter_order;

        Storage::putFileAs($path, $video, $uuid);

        SectionChapter::create([
            "title" => $request['title'],
            "description" => $request['description'],
            "chapter_order" => $lastOrder + 1,
            "url_video" => $storeUrl,
            "duration" => $duration,
            "section_id" => $section->id
        ]);

        $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();
            
        $sectionActive = getActiveSection($request['sectionActive']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
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

    public function update(FreeCourseService $freeCourseService, Request $request, SectionChapter $chapter) // FALTA
    {
        $order = $request['order'];
        $url_video = $chapter->url_video;
        $duration = $chapter->duration;

        $section = $chapter->courseSection;

        if ($order != $chapter->chapter_order) {
            SectionChapter::where('section_id', $chapter->section_id)
                ->where('chapter_order', $order)
                ->update([
                    "chapter_order" => $chapter->chapter_order
                ]);
        }

        if ($request->has('file')) {

            if ($url_video != null && Storage::exists($url_video)) {
                Storage::delete($url_video);
            }

            $videoDur = new GetId3($request->file('file'));
            $duration = round($videoDur->getPlaytimeSeconds() / 60);

            $path = 'videos/freecourses/' . $section->course_id . '/' . $section->id . '/';
            $video = $request->file('file');
            $uuid = $video->hashName();
            Storage::putFileAs($path, $video, $uuid);
            $url_video = $path . $uuid;
        }

        $chapter->update([
            "title" => $request['title'],
            "description" => $request['description'],
            "chapter_order" => $order,
            "url_video" => $url_video,
            "duration" => $duration
        ]);

        $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
            "htmlChapter" => $htmlChapter,
            "htmlCourse" => $htmlCourse,
            "id" => $section->id
        ]);
    }

    public function destroy(FreeCourseService $freeCourseService, Request $request, SectionChapter $chapter) // FALTA
    {
        $section = $chapter->courseSection;

        $chapter->progressUsers()->detach();
        $video_path =  $chapter->url_video;
        Storage::delete($video_path);

        $chapter->delete();

        $chapters = SectionChapter::where('section_id', $section->id)
                    ->orderBy('chapter_order', 'ASC')->get();

        $order = 1;
        foreach ($chapters as $remanentChapter) {
            $remanentChapter->update([
                "chapter_order" => $order
            ]);
            $order++;
        }

        $course = $freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('id', $section->course_id)
                                            ->first();

        $sectionActive = getActiveSection($request['id']);

        $htmlCourse = view('admin.free-courses.partials.course-box', compact('course'))->render();
        $htmlSection = view('admin.free-courses.partials.sections-list', compact('course', 'sectionActive'))->render();
        $htmlChapter = view('admin.free-courses.partials.chapters-list', compact('section'))->render();

        return response()->json([
            "htmlCourse" => $htmlCourse,
            "htmlSection" => $htmlSection,
            "htmlChapter" => $htmlChapter,
            "id" => $section->id
        ]);
    }

}
