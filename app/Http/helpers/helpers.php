<?php

use Illuminate\Support\Facades\Storage;
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
    OwnerCompany,
    Document,
    CourseSection,
    SectionChapter
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
    $exam = $certification->event->exam;

    return $exam;
}

function getCourseFromEvent(Event $event)
{
    $course = $event->exam->course;

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
    $user = Auth::user();

    $certifications = $user->certifications()->with('event.exam.ownerCompany')->get()
                            ->filter(function($certification) use ($course){
                            if($certification->event->exam->course_id == $course->id && $certification->evaluation_type == 'certification')
                            return $certification;
                    })->sortByDesc('id');

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


function updateIfNotFinished($certification) : void
{
    $current_date_string = Carbon::now('America/Lima')->format('Y-m-d');
    $current_date = Carbon::parse($current_date_string);
    $event_date = Carbon::parse(($certification->event->date));

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
    $user = Auth::user();

    if ($user->role == 'instructor')
    {
        $courses = Course::join('exams', 'exams.course_id', '=', 'courses.id')
                        ->join('events', 'events.exam_id', '=', 'exams.id')
                        ->join('users', 'events.user_id', '=', 'users.id')
                        ->where('users.id', $user->id)
                        ->where('courses.active', 'S')
                        ->where('courses.course_type', 'REGULAR')
                        ->distinct()->get('courses.*');
    }
    else if($user->role == 'participants'){

        $courses = $user->certifications()->where('evaluation_type', 'certification')
                    ->with('event.exam.course')
                    ->get()->pluck('event.exam.course')->unique();

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
    $ownerCompany = $certification->event->exam->ownerCompany;

    return $ownerCompany;
}

function getCurrentDate()
{
    return Carbon::now('America/Lima')->format('Y-m-d');
}

function getFreeCourseTotalTime(Course $course)
{
    $totalTime = SectionChapter::join('course_sections', 'course_sections.id', '=', 'section_chapters.section_id')
                                ->join('courses', 'courses.id', '=', 'course_sections.course_id')
                                ->where('courses.id', $course->id)
                                ->sum('section_chapters.duration');

    $hours = intdiv($totalTime, 60);
    $minuts = $totalTime % 60;

    return $hours.' hrs '.$minuts.' minutos';
}


function getShowSection(SectionChapter $current_chapter, CourseSection $section)
{
    return $current_chapter->courseSection->id == $section->id ? 'show' : '';
}


function getNextChapter($next_sections, SectionChapter $current_chapter)
{
    $next_chapter = null;
    $i = 0;
    foreach($next_sections as $section)
    {
        if($i == 0)
        {
            $next_chapter = $section->sectionChapters->where('chapter_order', $current_chapter->chapter_order + 1)->first();
        }
        else{
            $next_chapter = $section->sectionChapters->where('chapter_order', 1)->first();
        }

        if($next_chapter != null)
        {
            break;
        }
        $i++;
    }

    return $next_chapter;
}

function getPreviousChapter($previous_sections, SectionChapter $current_chapter)
{
    $previous_chapter = null;
    $i = 0;

    foreach($previous_sections as $section)
    {
        if($i == 0)
        {
            $previous_chapter = $section->sectionChapters->where('chapter_order', $current_chapter->chapter_order - 1)->first();
        }
        else{
            $previous_chapter = $section->sectionChapters->where('chapter_order', count($section->sectionChapters))->first();
        }

        if($previous_chapter != null)
        {
            break;
        }

        $i++;
    }

    return $previous_chapter;
}


function getItsChapterFinished(SectionChapter $chapter)
{
    $user = Auth::user();

    return $user->progressChapters()->wherePivot('section_chapter_id', $chapter->id)
                                    ->wherePivot('status', 'F')->first() != null ? true : false;
}

function getNFinishedChapters($section)
{
    $user = Auth::user();

    $Nchapters = $user->progressChapters()->join('course_sections', 'course_sections.id', '=', 'section_chapters.section_id')
                                            ->where('course_sections.id', $section->id)
                                            ->wherePivot('status', 'F')
                                            ->count();
    return $Nchapters;
}








































function getFileExtension(Document $document)
{
    $folder = $document->folder;
    $pathToFile = $folder->folder_path.$document->uuid;

    $fileExt = File::extension($pathToFile);

    switch($fileExt)
    {
        case 'ai':
            $extension = 'ai';
            break;
        case 'avi':
            $extension = 'avi';
            break;
        case 'csv':
            $extension = 'csv';
            break;
        case 'eps':
            $extension = 'eps';
            break;
        case 'docx':
        case 'doc':
            $extension = 'docx';
            break;
        case 'flv':
            $extension = 'flv';
            break;
        case 'gif':
            $extension = 'gif';
            break;
        case 'html':
            $extension = 'html';
            break;
        case 'java':
            $extension = 'java';
            break;  
        case 'jpg':
        case 'jpeg':
        case 'jfif':
        case 'pjeg':
        case 'pjp':
            $extension = 'jpg';
            break;
        case 'mid':
        case 'midi':
            $extension = 'mid';
            break;
        case 'mov':
            $extension = 'mov';
            break;
        case 'mp4':
        case 'm4p':
        case 'm4v':
            $extension = 'mp4';
            break;
        case 'mpeg':
        case 'mpg':
        case 'mp2':
        case 'mpe':
        case 'mpv':
        case 'm2v':
            $extension = 'mpeg';
            break;
        case 'pdf':
            $extension = 'pdf';
            break;
        case 'png':
            $extension = 'png';
            break;
        case 'pptx':
        case 'pptm':
        case 'ppt':
            $extension = 'ppt';
            break;
        case 'psd':
            $extension = 'psd';
            break;
        case 'rar':
            $extension = 'rar';
            break;
        case 'rss':
            $extension = 'rss';
            break;
        case 'svg':
            $extension = 'svg';
            break;
        case 'txt':
            $extension = 'txt';
            break;
        case 'wav':
            $extension = 'wav';
            break;
        case 'vma':
            $extension = 'vma';
            break;
        case 'xml':
            $extension = 'xml';
            break;
        case 'xlsx':
        case 'xls':
            $extension = 'xsl';
            break;
        case 'zip':
            $extension = 'zip';
            break;
        default:
            $extension = 'default';
    }

    return $extension;
}






?>