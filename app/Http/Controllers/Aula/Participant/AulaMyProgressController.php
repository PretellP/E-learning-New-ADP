<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Course;

class AulaMyProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $courses = $user->certifications()->where('evaluation_type', 'certification')
                        ->with(['event'=>fn($query)=>$query
                            ->select('id','exam_id')
                            ->with(['exam'=>fn($query2)=>$query2
                                ->select('id','course_id')
                                ->with('course:id,url_img,description,hours')
                            ])
                        ])->select('certifications.id',
                                'certifications.event_id',
                                'certifications.assist_user',
                                'certifications.status',
                                'certifications.score')
                        ->get()->groupBy('event.exam.course.id');

        $freeCourses = $user->progressChapters()
                        ->with(['courseSection' => fn($query) => $query
                            ->select('id','course_id')
                            ->with(['course'=>fn($query2)=>$query2
                                ->select('id','url_img','description')
                                ->with(['courseSections'=>fn($query3)=>$query3
                                    ->select('id','course_id')
                                    ->with('sectionChapters:id,section_id,duration')
                                ])
                            ])
                        ])->select('section_chapters.id',
                                'section_chapters.section_id')
                        ->get()->groupBy('courseSection.course.id');
                
        return view('aula2.viewParticipant.myprogress.index', [
            'courses' => $courses,
            'freeCourses' => $freeCourses,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
