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
    SectionChapter,
    Survey,
    UserSurvey,
    SurveyStatement,
    SurveyOption
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
    return $certification->event->exam;
}

function getCourseFromEvent(Event $event)
{
    return $event->exam->course;
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
    $score = $certification->evaluations->sum('points');

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

    $certifications = $user->certifications()
                            ->select('id','user_id','event_id','evaluation_type',
                                    'status','score','assist_user','evaluation_time')
                            ->with('evaluations:id,certification_id,points')
                            ->with([
                                'event'=>fn($query)=>$query
                                ->select('id','exam_id','date','description','user_id')
                                ->with('user:id,name,paternal,maternal')
                                ->with([
                                    'exam'=>fn($query2)=>$query2
                                    ->select('id','course_id','owner_company_id','exam_time')
                                    ->with('ownerCompany:id,name')
                                ])
                            ])
                            ->get()
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
        $courses = $user->events()->select('id','user_id','exam_id')
                        ->with(['exam'=>fn($query)=>$query 
                                ->select('id','course_id')
                                ->with('course:id,url_img,description,hours')
                            ])
                        ->with([
                            'certifications'=>fn($query)=>$query
                            ->where('evaluation_type', 'certification')
                            ->select('user_id','event_id')
                        ])
                        ->get()->groupBy('exam.course.id');

    }
    else if($user->role == 'participants'){

        $courses = $user->certifications()
                        ->where('evaluation_type', 'certification')
                        ->with([
                            'event'=>fn($query)=>$query
                            ->select('id','user_id','exam_id')
                            ->with('user:id,name,paternal,maternal')
                            ->with([
                                'certifications'=>fn($query2)=>$query2
                                ->where('evaluation_type', 'certification')
                                ->select('user_id','event_id')
                            ])
                            ->with([
                                'exam'=>fn($query3)=>$query3
                                ->select('id','course_id')
                                ->with('course:id,url_img,description,hours')
                            ])
                        ])->select('certifications.id',
                                    'certifications.event_id')
                        ->get()->groupBy('event.exam.course.id');
    }

    return $courses;
}


function getInstructorsBasedOnUserAndCourse($currentRelation)
{
    $user = Auth::user();
    $role = $user->role;

    if($role == 'instructor')
    {
        $instructors = collect();
        $instructors = $instructors->push($user);
    }
    else if($role == 'participants')
    {
        $instructors = $currentRelation->groupBy('event.user.id')
                                        ->map(function($certification){
                                            return $certification->first()->event->user;
                                        });
    }

    return $instructors; 
}

function getDiffForHumansFromTimestamp($timestamp)
{
    return Carbon::parse($timestamp)->diffForHumans();
}

function getNStudentsFromCourse($currentRelation)
{
    $role = Auth::user()->role;

    if($role == 'participants')
    {
        $nstudents = $currentRelation->map(function($certification){{
                                    return $certification->event->certifications
                                    ->pluck('user_id');
                                }})->collapse()->unique()->count();
    }
    elseif($role == 'instructor')
    {
        $nstudents = $currentRelation->map(function($event){
                                        return $event->certifications
                                        ->pluck('user_id');
                                    })->collapse()->unique()->count();
    }

    return $nstudents;
}

function getOwnerCompanyFromCertification(Certification $certification)
{
    return $certification->event->exam->ownerCompany;
}

function getCurrentDate()
{
    return Carbon::now('America/Lima')->format('Y-m-d');
}

function getFreeCourseTime(Course $course)
{
    $totalTime = $course->courseSections
                ->sum(function($section){
                    return $section->sectionChapters
                            ->sum('duration');
                   });
   

    $hours = intdiv($totalTime, 60);
    $minuts = $totalTime % 60;

    return $hours.' hrs '.$minuts.' minutos';
}


function getFreeCourseTotalChapters(Course $course)
{
    $totalChapters = $course->courseSections
                        ->sum(function($section){
                        return $section->sectionChapters->count();
                    });

    return $totalChapters;
}


function getCompletedChapters($progress)
{
    $completedChapters = $progress->sum(function($chapter){
                            return $chapter->pivot->status == 'F' ? 1 : 0;
                        });

    return $completedChapters;
}


function getShowSection(CourseSection $current_section, CourseSection $section)
{
    return $current_section->id == $section->id ? 'show' : '';
}


function getNextChapter($next_sections, SectionChapter $current_chapter)
{
    $next_chapter = null;
    $i = 0;
    foreach($next_sections as $section)
    {
        $next_chapter = $i == 0 ? 
                        $section->sectionChapters
                                ->where('chapter_order', $current_chapter->chapter_order + 1)
                                ->first() 
                        : $section->sectionChapters
                                ->where('chapter_order', 1)
                                ->first();

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
        $previous_chapter = $i == 0 ?
                            $section->sectionChapters
                                ->where('chapter_order', $current_chapter->chapter_order - 1)
                                ->first()
                            : $section->sectionChapters
                                ->where('chapter_order', count($section->sectionChapters))
                                ->first();

        if($previous_chapter != null)
        {
            break;
        }

        $i++;
    }

    return $previous_chapter;
}


function getItsChapterFinished(SectionChapter $chapter, $allProgress)
{
    $progress = $allProgress->where('id', $chapter->id)->first();
    if($progress)
    {
        return $progress->pivot->status == 'F' ? true : false;
    }

}

function getNFinishedChapters($section, $allProgress)
{
    $Nchapters = $allProgress->where('section_id', $section->id)
                            ->sum(function($chapter){
                                return $chapter->pivot->status == 'F' ? 1 : 0;
                            });

    return $Nchapters;
}


function validateSurveys()
{
    $user = Auth::user();
    $surveys = $user->userSurveys()->whereHas('survey', function($query){
                                        $query->where('active', 'S');
                                    })
                                    ->with('survey:id,destined_to')
                                    ->get();

    $checkEmptyCourseLive = $surveys->filter(function ($survey){
                                    return $survey->survey->destined_to == 'course_live';
                                })->isEmpty();
    $checkEmptyUserProfile = $surveys->filter(function($survey){
                                    return $survey->survey->destined_to == 'user_profile';
                                })->isEmpty();

    if($checkEmptyCourseLive)
    {   
        $survey_cl = Survey::where('destined_to', 'course_live')->first();

        if($survey_cl != null)
        {
            UserSurvey::create([
                'user_id' => $user->id,
                'survey_id' => $survey_cl->id,
                'date' => getCurrentDate(),
                'status' => 'pending',
                'start_time' => null,
                'end_time' => null,
                'total_time' => null,
                'course_id' => null
            ]);
        }
    }
    if($checkEmptyUserProfile)
    {
        $survey_up = Survey::where('destined_to', 'user_profile')->first();

        if($survey_up != null)
        {
            UserSurvey::create([
                'user_id' => $user->id,
                'survey_id' => $survey_up->id,
                'date' => getCurrentDate(),
                'status' => 'pending',
                'start_time' => null,
                'end_time' => null,
                'total_time' => null,
                'course_id' => null
            ]);
        }
    
    }

    $checkPendingSurveys = $surveys->filter(function($survey){
                                return $survey->status == 'pending';
                            })->isNotEmpty();

    return $checkPendingSurveys;
}


function getStatementsFromUserSurvey(UserSurvey $userSurvey)
{
    $statements = $userSurvey->survey->with(['surveyGroups'=>fn($query)=>$query
                                            ->select('id','survey_id')
                                            ->with('statements:id,description,group_id')
                                        ])
                                        ->first()
                                        ->surveyGroups->map(function($group){
                                            return $group->statements;
                                        })->flatten();

    return $statements;
}

function getOptionsFromStatement(SurveyStatement $statement)
{
    $options = $statement->options->sortByDesc('description');
    
    return $options;
}

function getChekedInput(SurveyStatement $statement, SurveyOption $option)
{
    return $statement->pivot->answer == $option->description ? 'checked': '';
}

function verifyLastSurveyGroup($answersByGroup, $group_position)
{
    return $answersByGroup->count() == $group_position ? true : false;
}

function getTimeforHummans($time)
{
    return Carbon::parse($time)->format('g:i A');
}


function getStatusClass($status)
{
    return $status == 'S' ? 'active' : '';
}

function getStatusText($status)
{
    return $status == 'S' ? 'Activo' : 'Inactivo';
}

function getStatusRecomended($status)
{
    return $status == 1 ? '<i class="fa-solid fa-star flg-recom-btn active"></i>' :
                        '<i class="fa-regular fa-star flg-recom-btn"></i>';
}

function getSelectedOption(CourseSection $section, $order)
{
    return $section->section_order == $order ? 'selected' : '';
}

function setSectionActive(CourseSection $section, $sectionActive)
{
    return $section->id == $sectionActive ? 'active' : '';
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