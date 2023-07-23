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
        $categories = CourseCategory::where('status', 'S')->get();

        $courses = Course::where('course_type', 'FREE')
                        ->where('flg_recom', 1)->get();

        return view('aula2.viewParticipant.freecourses.index', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }



    public function start(Course $course)
    {
        $user = User::findOrFail(Auth::user()->id);
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



    public function showCourse(Course $course, SectionChapter $current_chapter)
    {
        $sections = CourseSection::with('sectionChapters')->where('course_id', $course->id)
                                ->orderBy('section_order', 'ASC')->get();
        
        return view('aula2.viewParticipant.freecourses.showChapter', [
            'course' => $course,
            'sections' => $sections,
            'current_chapter' => $current_chapter
        ]);
    }



    public function updateChapter(SectionChapter $current_chapter, SectionChapter $new_chapter)
    {
        $user = User::findOrFail(Auth::user()->id);

        $user->progressChapters()->updateExistingPivot($current_chapter, [
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
