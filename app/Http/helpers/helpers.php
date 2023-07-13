<?php

use Carbon\Carbon;
use App\Models\{
    DynamicQuestion,
    DynamicAlternative,
    Certification,
    Event,
    Course,
    DroppableOption,
    User,
    Company,
    MiningUnits,
    OwnerCompany
};

date_default_timezone_set("America/Lima");



function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active':'';
}

function getSelectedAnswers($certification)
{
    $num_question = count($certification->evaluations()
                    ->where('selected_alternatives', '!=', null)
                    ->get());
                
    return $num_question;
}

function getExamFromCertification($certification)
{
    $exam = ($certification->event()->get()->first())
                ->exam()->get()->first();

    return $exam;
}

function getCourseFromEvent(Event $event)
{
    $course = ($event->exam()->first())->course()->first();

    return $course;
}

function getQuestionsFromExam($exam)
{
    $questions = $exam->questions()->inRandomOrder()->get();

    return $questions;
}

function getCorrectAltFromQuestion($question)
{
    $correct_alternatives = $question->alternatives()
                                    ->where('is_correct', 1)
                                    ->get();

    return $correct_alternatives;
}

function getScoreFromCertification($certification)
{
    $score = $certification->evaluations()->sum('points');

    return $score;
}

function getTimeDifference($evalOrCertif, $exam)
{
    $evaluation_time = $evalOrCertif->evaluation_time;
    $diff_time = ($evaluation_time + ($exam->exam_time * 60)) - time();

    return $diff_time;
}

function getItsTimeOut($diff_time)
{
    return $diff_time+1 < 0 ? true : false;
}

function getCertificationsFromCourse(Course $course)
{
    $certifications = Certification::join('events', 'certifications.event_id', '=', 'events.id')
                            ->join('exams', 'events.exam_id', '=', 'exams.id')
                            ->join('courses', 'exams.course_id', '=', 'courses.id')
                            ->where('courses.id', $course->id)
                            ->where('certifications.evaluation_type', '=', 'certification')
                            ->where('certifications.user_id', '=', Auth::user()->id)
                            ->orderBy('certifications.id', 'DESC')
                            ->get('certifications.*');

    return $certifications;
}

function getDroppableOptionsFromQuestion($question)
{
    $droppable_options = DroppableOption::join('dynamic_alternatives', 'dynamic_alternatives.id', '=', 'droppable_options.dynamic_alternative_id')
                                        ->join('dynamic_questions', 'dynamic_questions.id', '=', 'dynamic_alternatives.dynamic_question_id')
                                        ->where('dynamic_questions.id', $question->id)
                                        ->get('droppable_options.*');

    return $droppable_options;
}

function getAlternativeFromId($id)
{
    return DynamicAlternative::findOrFail($id);
}

function getDroppableOptionFromId($id)
{
    return DroppableOption::findOrFail($id);
}


function updateIfNotFinished(Certification $certification) : void
{
    $current_date_string = Carbon::now('America/Lima')->format('Y-m-d');
    $current_date = Carbon::parse($current_date_string);
    $event_date = Carbon::parse(($certification->event()->first('date'))->date);

    if($current_date->greaterThan($event_date) && $certification->status != 'finished')
    {
        $exam = getExamFromCertification($certification);
        $total_time = $exam->exam_time;
        $score = getScoreFromCertification($certification);

        $certification->update([
            'status' => 'finished',
            'end_time' => Carbon::now('America/Lima'),
            'total_time' => $total_time,
            'score' => $score,
        ]);
    }
    
    else if ($certification->status == 'in_progress')
    {
        $exam = getExamFromCertification($certification);
        $diff_time = getTimeDifference($certification, $exam);
        $its_time_out = getItsTimeOut($diff_time);

        if ($its_time_out)
        {
            $total_time = $exam->exam_time;
            $score = getScoreFromCertification($certification);
            
            $certification->update([
                'status' => 'finished',
                'end_time' => Carbon::now('America/Lima'),
                'total_time' => $total_time,
                'score' => $score,
            ]);
        }
    }
}



function getCoursesBasedOnRole()
{
    $role = Auth::user()->role;

    if ($role == 'instructor')
    {
        $courses = Course::join('exams', 'exams.course_id', '=', 'courses.id')
                        ->join('events', 'events.exam_id', '=', 'exams.id')
                        ->join('users', 'events.user_id', '=', 'users.id')
                        ->where('users.id', Auth::user()->id)
                        ->where('courses.active', 'S')
                        ->distinct()->get('courses.*');
    }
    else if($role == 'participants'){

        $courses = Course::join('exams', 'exams.course_id', '=', 'courses.id')
                        ->join('events', 'events.exam_id', '=', 'exams.id')
                        ->join('certifications', 'certifications.event_id', '=', 'events.id')
                        ->join('users', 'users.id', '=', 'certifications.user_id')
                        ->where('users.id', Auth::user()->id)
                        ->where('courses.active', 'S')
                        ->distinct()->get('courses.*');
    }

    return $courses;
}


function getInstructorsBasedOnUserAndCourse(Course $course)
{
    $role = Auth::user()->role;

    $instructors = collect();

    if($role == 'instructor')
    {
        $instructors = $instructors->push((User::FindOrFail(Auth::user()->id)));
    }
    else if($role == 'participants')
    {
        $instructors_ids = Event::join('exams', 'events.exam_id', '=', 'exams.id')
                            ->join('courses', 'exams.course_id', '=', 'courses.id')
                            ->join('certifications', 'events.id', '=', 'certifications.event_id')
                            ->join('users', 'certifications.user_id', '=', 'users.id')
                            ->where('users.id', Auth::user()->id)
                            ->where('courses.id', $course->id)
                            ->distinct()->get('events.user_id');

        foreach($instructors_ids as $instructor_id)
        {
            $instructor = User::findOrFail($instructor_id->user_id);
            $instructors = $instructors->push($instructor);
        }
    }

    return $instructors; 
}

function getCompanyFromUser()
{
   $company = Company::findOrFail(Auth::user()->company_id);

   return $company;
}

function getMiningUnitsFromUser()
{
    $user = User::findOrFail(Auth::user()->id);

    $mining_units = $user->miningUnits()->get();

    return $mining_units;
}

function getUserFromId($id)
{
    return User::findOrFail($id);
}

function getDiffForHumansFromTimestamp($timestamp)
{
    return Carbon::parse($timestamp)->diffForHumans();
}

function getEventsFromCourse(Course $course)
{
    $role = Auth::user()->role;

    if($role == 'instructor')
    {
        $events = Event::join('users', 'events.user_id', '=', 'users.id')
                        ->join('exams', 'events.exam_id', '=', 'exams.id')
                        ->join('courses', 'exams.course_id', '=', 'courses.id')
                        ->where('courses.id', $course->id)
                        ->where('users.id', Auth::user()->id)
                        ->distinct()->get('events.*');
    }
    else if($role == 'participants')
    {
        $events = Event::join('certifications', 'certifications.event_id', '=', 'events.id')
                        ->join('users', 'certifications.user_id', '=', 'users.id')
                        ->join('exams', 'events.exam_id', '=', 'exams.id')
                        ->join('courses', 'exams.course_id', '=', 'courses.id')
                        ->where('courses.id', $course->id)
                        ->where('users.id', Auth::user()->id)
                        ->distinct()->get('events.*');  
    }

    return $events;
}

function getNStudentsFromCourse(Course $course)
{
    $events = getEventsFromCourse($course);
    $students_collect = collect();

    foreach($events as $event)
    {
        $students = User::join('certifications', 'certifications.user_id', '=', 'users.id')
                        ->join('events', 'certifications.event_id', '=', 'events.id')
                        ->where('events.id', $event->id)
                        ->distinct()->get('users.*');

        foreach($students as $student)
        {
            if(!($students_collect->contains($student)))
            {
                $students_collect = $students_collect->push($student);
            }
        }
    }
    
    return $students_collect->count();
}

function getOwnerCompanyFromCertification(Certification $certification)
{
    $ownerCompany = (($certification->event()->first())
                    ->exam()->first())->ownerCompany()->first();

    return $ownerCompany;
}

function getCurrentDate()
{
    return Carbon::now('America/Lima')->format('Y-m-d');
}

?>