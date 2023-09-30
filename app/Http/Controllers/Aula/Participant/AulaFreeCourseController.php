<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{
    Course,
    CourseCategory,
    SectionChapter
};
use App\Services\FreeCourseService;

class AulaFreeCourseController extends Controller
{
    private $freeCourseService;

    public function __construct(FreeCourseService $service)
    {
        $this->freeCourseService = $service;
    }

    public function index()
    {
        $user = Auth::user();
        $categories = $this->freeCourseService->withCategoryRelationshipsQuery()
                                            ->where('status', 'S')
                                            ->select('id', 'description')
                                            ->get();

        $coursesProgress = $user->progressChapters()
                                ->with('courseSection:id,course_id')
                                ->select('section_chapters.id', 'section_chapters.section_id')
                                ->get()
                                ->groupBy('courseSection.course_id');

        $allCourses = $this->freeCourseService->withFreeCourseRelationshipsQuery()
                                            ->where('flg_recom', 1)
                                            ->orWhere('id', $coursesProgress->keys()->all())
                                            ->where('active', 'S')
                                            ->having('course_chapters_count', '>', 0)
                                            ->get();

        $recomendedCourses = $allCourses->where('flg_recom', 1);

        $followingCourses = $this->freeCourseService->getPendingAndFinishedCourses($allCourses, $coursesProgress);
        $pendingCourses = $followingCourses[0];
        $finishedCourses = $followingCourses[1];

        return view('aula.viewParticipant.freecourses.index', [
            'recomendedCourses' => $recomendedCourses,
            'categories' => $categories,
            'pendingCourses' => $pendingCourses,
            'finishedCourses' => $finishedCourses
        ]);
    }

    public function start(Course $course)
    {
        $user = Auth::user();

        if ($course->active == 'S') {
            $progress = $user->progressChapters()
                ->wherePivot('last_seen', 1)
                ->whereHas('courseSection', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->select('section_chapters.id', 'section_chapters.section_id')
                ->first();

            if ($progress == null) {
                $current_chapter = $course->courseSections()
                    ->select('id', 'section_order', 'course_id')
                    ->where('section_order', 1)
                    ->with([
                        'sectionChapters' => fn ($query) => $query
                            ->select('id', 'section_id', 'chapter_order')
                            ->where('chapter_order', 1)
                    ])
                    ->first()->sectionChapters->first();

                $verifyProgress = $user->progressChapters()
                    ->where('section_chapter_id', $current_chapter->id)
                    ->first();

                if ($verifyProgress == null) {
                    $user->progressChapters()->attach($current_chapter, [
                        'progress_time' => 0,
                        'last_seen' => 1,
                        'status' => 'P'
                    ]);
                } else {
                    $user->progressChapters()->updateExistingPivot($current_chapter, [
                        'last_seen' => 1,
                    ]);
                }
            } else {
                $current_chapter = $progress;
            }

            return redirect()->route('aula.freecourse.showChapter', [
                'course' => $course,
                'current_chapter' => $current_chapter
            ]);
        } else {
            return redirect()->route('aula.freecourse.index');
        }
    }

    public function showCategory(CourseCategory $category)
    {
        $courses = $this->freeCourseService->attachFreeCourseRelationships($category->courses())
                        ->where('active', 'S')
                        ->having('course_chapters_count', '>', 0)
                        ->get();

        return view('aula.viewParticipant.freecourses.showCategory', [
            'category' => $category,
            'courses' => $courses
        ]);
    }

    public function showChapter(Course $course, SectionChapter $current_chapter)
    {
        $user = Auth::user();

        if ($course->active == 'S') {

            $course->loadFreeCourseImage();

            $allProgress = $user->progressChapters()->whereHas('courseSection', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
                ->select(
                    'section_chapters.id',
                    'section_chapters.section_id',
                    'section_chapters.title',
                    'section_chapters.description',
                    'section_chapters.url_video',
                    'section_chapters.chapter_order'
                )
                ->get();

            $sections = $this->freeCourseService->attachSectionRelationships($course->courseSections())
                            ->having('section_chapters_count', '>', 0)
                            ->get();

            $current_chapter = $allProgress->where('id', $current_chapter->id)->first();

            if ($current_chapter != null) {
                $current_time = $current_chapter->pivot->progress_time;
            } else {
                abort(404);
            }

            $current_section = $sections->filter(function ($section) use ($current_chapter) {
                return $section->id == $current_chapter->section_id;
            })->first();

            $next_sections = $sections->whereIn(
                'section_order',
                [
                    $current_section->section_order,
                    $current_section->section_order + 1
                ]
            );

            $next_sections = $sections->where('section_order', '>=', $current_section->section_order)->take(2);
            $next_chapter = $this->freeCourseService->getNextChapter($next_sections, $current_chapter);

            $previous_sections = $sections->where('section_order', '<=', $current_section->section_order)->reverse()->take(2);
            $previous_chapter = $this->freeCourseService->getPreviousChapter($previous_sections, $current_chapter);

            return view('aula.viewParticipant.freecourses.showChapter', [
                'course' => $course,
                'sections' => $sections,
                'current_chapter' => $current_chapter,
                'current_section' => $current_section,
                'next_chapter' => $next_chapter,
                'previous_chapter' => $previous_chapter,
                'current_time' => $current_time,
                'allProgress' => $allProgress
            ]);
        } else {
            return redirect()->route('aula.freecourse.index');
        }
    }

    public function updateChapter(SectionChapter $current_chapter, SectionChapter $new_chapter, Course $course)
    {
        $user = Auth::user();

        $lastSeenChapter = $user->progressChapters()->whereHas('courseSection.course', function ($query) use ($course) {
            $query->where('id', $course->id);
        })
            ->wherePivot('last_seen', 1)
            ->select('section_chapters.id', 'section_chapters.section_id')
            ->first();

        $user->progressChapters()->updateExistingPivot($lastSeenChapter, [
            'last_seen' => 0,
        ]);

        $next_relation = $user->progressChapters()->wherePivot('section_chapter_id', $new_chapter->id)
            ->select('section_chapters.id', 'section_chapters.section_id')
            ->first();

        if ($next_relation == null) {
            $user->progressChapters()->attach($new_chapter, [
                'progress_time' => 0,
                'last_seen' => 1,
                'status' => 'P'
            ]);
        } else {
            $user->progressChapters()->updateExistingPivot($new_chapter, [
                'last_seen' => 1,
            ]);
        }

        return redirect()->route('aula.freecourse.showChapter', [
            'course' => $course,
            'current_chapter' => $new_chapter
        ]);
    }

    public function updateProgressTime(Request $request, SectionChapter $current_chapter)
    {
        $user = Auth::user();
        $time = floor($request->time);
        $duration = floor($request->duration);

        $checkFinished = false;

        if ($time / $duration >= 0.95) {
            $user->progressChapters()->updateExistingPivot($current_chapter, [
                'progress_time' => $time,
                'status' => 'F'
            ]);

            $checkFinished = true;
        } else {
            $user->progressChapters()->updateExistingPivot($current_chapter, [
                'progress_time' => $time,
                'status' => 'P'
            ]);
        }

        return response()->json(['check' => $checkFinished]);
    }
}
