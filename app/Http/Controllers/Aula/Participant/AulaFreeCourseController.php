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
        $categories = CourseCategory::where('status', 'S')->select('id','url_img','description')->get();

        $recomendedCourses = Course::where('course_type', 'FREE')
                                    ->where('flg_recom', 1)
                                    ->with(['courseSections'=>fn($query)=>$query->select('id','course_id')
                                        ->with('sectionChapters:id,section_id,duration')])
                                    ->with('courseCategory:id,description')
                                    ->select('id','url_img','description','category_id')->get();

        $followingCourses = $user->progressChapters()
                                ->with(['courseSection' => fn($query) => $query
                                    ->with(['course' => fn($query2) => $query2
                                        ->with('courseCategory:id,description')
                                        ->with(['courseSections'=>fn($query3)=>$query3
                                            ->select('id','course_id')
                                            ->with('sectionChapters:id,section_id,duration')])
                                        ->select('id','url_img','description','category_id')
                                        ])->select('id','course_id')
                                    ])
                                ->select('section_chapters.id','section_chapters.section_id')
                                ->get()->groupBy('courseSection.course.id');
    
        $pendingCourses = collect();
        $finishedCourses = collect();

        foreach($followingCourses as $followingCourse)
        {
            $freeCourse = $followingCourse->first()->courseSection->course;
            $Nprogress = getCompletedChapters($followingCourse);
            $totalChapters = getFreeCourseTotalChapters($freeCourse);

            if($totalChapters == $Nprogress)
            {
                $finishedCourses->push($freeCourse);
            }
            else{
                $pendingCourses->push($freeCourse);
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

        $progress = $user->progressChapters()->select('section_chapters.id','section_chapters.section_id')
                                            ->with('courseSection:id,course_id')->get()
                                            ->filter(function($chapter) use($course){
                                            return $chapter->pivot->last_seen == 1 && $chapter->courseSection->course_id == $course->id;
                                        })->first();

        if($progress == null)
        {
            $current_chapter = $course->courseSections()->select('id','section_order','course_id')
                                                    ->where('section_order', 1)
                                                    ->with(['sectionChapters'=>fn($query)=>$query
                                                        ->select('id','section_id','chapter_order')
                                                        ->where('chapter_order', 1)
                                                    ])->first()->sectionChapters->first();

            $user->progressChapters()->attach($current_chapter, [
                'progress_time' => 0,
                'last_seen' => 1,
                'status' => 'P'
            ]);
        }
        else
        {
            $current_chapter = $progress;
        }

        return redirect()->route('aula.freecourse.showChapter', [
            'course' => $course,
            'current_chapter' => $current_chapter
        ]);
    }


    public function showCategory(CourseCategory $category)
    {
        $courses = $category->courses()
                            ->select('id','url_img','description','category_id')
                            ->with(['courseSections'=>fn($query)=>$query
                                ->select('id','course_id')
                                ->with('sectionChapters:id,section_id,duration')])
                            ->with('courseCategory:id,description')
                            ->get();

        return view('aula2.viewParticipant.freecourses.showCategory', [
            'category' => $category,
            'courses' => $courses
        ]);
    }


    public function showChapter(Course $course, SectionChapter $current_chapter)
    {
        $user = Auth::user();

        $allProgress = $user->progressChapters()->with(['courseSection'=>fn($query)=>$query
                                                    ->with(['course'=>fn($query2)=>$query2
                                                        ->with(['courseSections'=>fn($query3)=>$query3
                                                            ->with('sectionChapters')])
                                                        ])
                                                    ])->get()->filter(function($chapter) use($course){
                                                        return $chapter->courseSection->course_id == $course->id;
                                                });

        $sections = $allProgress->first()->courseSection->course->courseSections;

        $current_chapter = $allProgress->where('id', $current_chapter->id)->first();

        if($current_chapter != null){
            $current_time = $current_chapter->pivot->progress_time;
        }else{
            return back();
        }
        
        $current_section_order = $current_chapter->courseSection->section_order;
        $next_sections = $sections->whereIn('section_order', [$current_section_order, $current_section_order + 1]);
        $next_chapter = getNextChapter($next_sections, $current_chapter);
        $previous_sections = $sections->whereIn('section_order', [$current_section_order, $current_section_order - 1])->reverse();
        $previous_chapter = getPreviousChapter($previous_sections, $current_chapter);

        return view('aula2.viewParticipant.freecourses.showChapter', [
            'course' => $course,
            'sections' => $sections,
            'current_chapter' => $current_chapter,
            'next_chapter' => $next_chapter,
            'previous_chapter' => $previous_chapter,
            'current_time' => $current_time,
            'allProgress' => $allProgress
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
