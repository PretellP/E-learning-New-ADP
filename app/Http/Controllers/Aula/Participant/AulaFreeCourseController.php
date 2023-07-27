<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\{
    Course,
    CourseCategory, 
    User,
    CourseSection,
    SectionChapter
};

class AulaFreeCourseController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $categories = CourseCategory::where('status', 'S')->get();

        $recomendedCourses = Course::where('course_type', 'FREE')
                                    ->where('flg_recom', 1)->get();

        $pendingCourses = collect();
        $finishedCourses = collect();

        $followingCourses = Course::with(['courseSections' => fn($query) => $query->withCount('sectionChapters')])
                                    ->join('course_sections', 'courses.id', '=', 'course_sections.course_id')
                                    ->join('user_course_progress', 'user_course_progress.section_chapter_id', '=', 'course_sections.id')
                                    ->where('user_course_progress.user_id', $user->id)->distinct()->get('courses.*');

        foreach($followingCourses as $followingCourse)
        {
            $Nprogress = $user->progressChapters()->join('course_sections', 'course_sections.id', '=', 'section_chapters.section_id')
                                                ->join('courses', 'courses.id', '=', 'course_sections.course_id')
                                                ->where('courses.id', $followingCourse->id)
                                                ->wherePivot('status', 'F')
                                                ->count();

            $totalChapters = $followingCourse->courseSections
                            ->reduce(function ($count, $section){
                                return $count + $section->section_chapters_count;
                            });

            if($totalChapters == $Nprogress)
            {
                $finishedCourses->push($followingCourse);
            }
            else{
                $pendingCourses->push($followingCourse);
            }
        }
      
        return view('aula2.viewParticipant.freecourses.index', [
            'recomendedCourses' => $recomendedCourses,
            'categories' => $categories,
            'pendingCourses' => $pendingCourses,
            'finishedCourses' => $finishedCourses
        ]);
    }


    public function start(Course $course)
    {
        $user = Auth::user();
        $progress = $user->progressChapters()->join('course_sections', 'course_sections.id', '=', 'section_chapters.section_id')
                                            ->join('courses', 'courses.id', '=', 'course_sections.course_id')
                                            ->where('courses.id', $course->id)
                                            ->wherePivot('last_seen', 1)
                                            ->first();

        if($progress == null)
        {
            $current_chapter = ($course->courseSections()->where('section_order', 1)->first())
                        ->sectionChapters()->where('chapter_order', 1)->first(); 

            $user->progressChapters()->attach($current_chapter, [
                'progress_time' => 0,
                'last_seen' => 1,
                'status' => 'P'
            ]);
        }
        else
        {
            $current_chapter = SectionChapter::findOrFail($progress->pivot->section_chapter_id);
        }

        return redirect()->route('aula.freecourse.showChapter', [
            'course' => $course,
            'current_chapter' => $current_chapter
        ]);
    }


    public function showCategory(CourseCategory $category)
    {
        $courses = $category->courses;

        return view('aula2.viewParticipant.freecourses.showCategory', [
            'category' => $category,
            'courses' => $courses
        ]);
    }


    public function showChapter(Course $course, SectionChapter $current_chapter)
    {
        $sections = CourseSection::with('sectionChapters')->where('course_id', $course->id)
                                ->orderBy('section_order', 'ASC')->get();

        $next_sections = $sections->whereIn('section_order', [$current_chapter->courseSection->section_order, $current_chapter->courseSection->section_order + 1]);

        $next_chapter = getNextChapter($next_sections, $current_chapter);

        $previous_sections = $sections->whereIn('section_order', [$current_chapter->courseSection->section_order, $current_chapter->courseSection->section_order - 1])->reverse();

        $previous_chapter = getPreviousChapter($previous_sections, $current_chapter);

        $current_progress = $current_chapter->progressUsers()->wherePivot('user_id', Auth::user()->id)->first();

        if($current_progress != null)
        {
            $current_time = $current_progress->pivot->progress_time;
        }
        else
        {
            return back();
        }
        
        return view('aula2.viewParticipant.freecourses.showChapter', [
            'course' => $course,
            'sections' => $sections,
            'current_chapter' => $current_chapter,
            'next_chapter' => $next_chapter,
            'previous_chapter' => $previous_chapter,
            'current_time' => $current_time
        ]);
    }



    public function updateChapter(SectionChapter $current_chapter, SectionChapter $new_chapter)
    {
        $course = $current_chapter->courseSection->course;

        $user = Auth::user();

        $lastSeenChapter = $user->progressChapters()->join('course_sections', 'course_sections.id', '=', 'section_chapters.section_id')
                                                    ->join('courses', 'courses.id', '=', 'course_sections.course_id')
                                                    ->where('courses.id', $course->id)
                                                    ->wherePivot('last_seen', 1)
                                                    ->first();

        $user->progressChapters()->updateExistingPivot($lastSeenChapter, [
            'last_seen' => 0,
        ]);

        $next_relation = $user->progressChapters()->wherePivot('section_chapter_id', $new_chapter->id)->first();

        if($next_relation == null)
        {
            $user->progressChapters()->attach($new_chapter, [
                'progress_time' => 0,
                'last_seen' => 1,
                'status' => 'P'
            ]);
        }
        else{
            $user->progressChapters()->updateExistingPivot($new_chapter, [
                'last_seen' => 1,
            ]);
        }

        $course = $new_chapter->courseSection->course;

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

        if($time/$duration >= 0.95)
        {
            $user->progressChapters()->updateExistingPivot($current_chapter, [
                'progress_time' => $time,
                'status' => 'F'
            ]);

            $checkFinished = true;
        }
        else{
            $user->progressChapters()->updateExistingPivot($current_chapter, [
                'progress_time' => $time,
                'status' => 'P'
            ]);
        }

        return response()->json(['check' => $checkFinished]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
