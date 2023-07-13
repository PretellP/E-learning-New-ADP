<?php

namespace App\Http\Controllers\Aula\Instructor;
use App\Models\{
    Course,
    Event
};
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AulaCourseInstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Course $course)
    {
        $events = Event::join('exams', 'exams.id', '=', 'events.exam_id')
                        ->join('courses', 'exams.course_id', '=', 'courses.id')
                        ->join('users', 'events.user_id', '=', 'users.id')
                        ->where('courses.id', $course->id)
                        ->where('users.id', Auth::user()->id)
                        ->orderBy('events.id', 'DESC')
                        ->get('events.*');

        return view('aula.viewInstructor.courses.show', [
            'course' => $course,
            'events' => $events
        ]);
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
