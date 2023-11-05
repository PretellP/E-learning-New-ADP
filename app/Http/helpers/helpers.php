<?php

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\{
    DynamicAlternative,
    Certification,
    Event,
    Course,
    DroppableOption,
    CourseSection,
    File as ModelsFile,
    SectionChapter,
    Survey,
    UserSurvey,
    SurveyStatement,
    SurveyOption,
    User
};

date_default_timezone_set("America/Lima");

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;

function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function getSelectedAnswers($certification)
{
    $num_question = $certification->evaluations()
        ->where('selected_alternatives', '!=', null)
        ->count();

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
    $certification->load(['evaluations' => function ($q) use ($certification) {
        $q->where('evaluation_time', $certification->evaluation_time)
            ->with('question');
    }]);

    $event = $certification->event;
    $exam = $event->exam;
    $points = $certification->evaluations->sum('points');
    $avg = $exam->questions_avg_points;

    $max_score = round($avg * $certification->evaluations->count());

    $correct_answers = 0;

    foreach($certification->evaluations as $evaluation){
        if($evaluation->points == $evaluation->question->points){
            $correct_answers++;
        }
    }

    $score = ($points > $max_score ||
            $correct_answers == $certification->evaluations->count()) ?
            $max_score : $points;

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
    return $diff_time + 1 < 0 ? true : false;
}

function getCertificationsFromCourse(Course $course)
{
    $user = Auth::user();

    $certifications = $user->certifications()
        ->select(
            'id',
            'user_id',
            'event_id',
            'evaluation_type',
            'status',
            'score',
            'assist_user',
            'evaluation_time'
        )
        ->with('evaluations:id,certification_id,points')
        ->with([
            'event' => fn ($query) => $query
                ->select('id', 'exam_id', 'type', 'date', 'description', 'user_id', 'min_score', 'questions_qty')
                ->with('user:id,name,paternal,maternal')
                ->with([
                    'exam' => fn ($query2) => $query2
                        ->select('id', 'course_id', 'owner_company_id', 'exam_time')
                        ->with('ownerCompany:id,name')
                        ->withCount('questions')
                        ->withAvg('questions', 'points')
                ])
        ])
        ->get()
        ->filter(function ($certification) use ($course) {
            if ($certification->event->exam->course_id == $course->id && $certification->evaluation_type == 'certification')
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
    return DynamicAlternative::with('file')->findOrFail($id);
}

function getDroppableOptionFromId($id)
{
    return DroppableOption::findOrFail($id);
}

function updateIfNotFinished($certification): void
{
    $current_date_string = Carbon::now('America/Lima')->format('Y-m-d');
    $current_date = Carbon::parse($current_date_string);
    $event_date = Carbon::parse(($certification->event->date));

    if ($current_date->greaterThan($event_date) && $certification->status != 'finished') {
        $exam = getExamFromCertification($certification);
        $total_time = $exam->exam_time;
        $score = getScoreFromCertification($certification);

        $certification->update([
            'status' => 'finished',
            'end_time' => Carbon::now('America/Lima'),
            'total_time' => $total_time,
            'score' => $score,
        ]);
    } else if ($certification->status == 'in_progress') {
        $exam = getExamFromCertification($certification);
        $diff_time = getTimeDifference($certification, $exam);
        $its_time_out = getItsTimeOut($diff_time);

        if ($its_time_out) {
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


/*-------------- E LEARNING ----------------*/

function getInstructorsBasedOnUserAndCourse($course)
{
    $user = Auth::user();
    $role = $user->role;

    if ($role == 'instructor') {
        $instructors = collect();
        $instructors = $instructors->push($user);
    } else if ($role == 'participants') {
        $instructors = $course->exams->map(function ($exam) {
            return $exam->events->map(function ($event) {
                return $event->user;
            });
        })->collapse()->unique();
    }

    return $instructors;
}

function getNStudentsFromCourse($course)
{
    $role = Auth::user()->role;

    if ($role == 'participants') {
        $nstudents = $course->exams->map(function ($exam) {
            return $exam->events->map(function ($event) {
                return $event->certifications->pluck('user_id');
            });
        })->flatten(2)->unique()->count();
    } elseif ($role == 'instructor') {
        $nstudents = $course->users_course_count;
    }

    return $nstudents;
}

function getProgressCertificationsFromCourse($course)
{
    $user = Auth::user();

    $certifications = $course->exams->map(function ($exam) {
        return $exam->events->map(function ($event) {
            return $event->certifications;
        });
    })->flatten(2)->where('user_id', $user->id);

    return $certifications;
}

function getEventFromCourseAndCertification($course, $certification)
{
    $event = $course->exams->map(function ($exam) {
        return $exam->events;
    })->flatten()->where('id', $certification->event_id)->first();

    return $event;
}

function getOwnerCompanyFromCertification(Certification $certification)
{
    return $certification->event->exam->ownerCompany;
}

// ------------------------------------------------




// ---------------- FREE COURSES ------------------


function getFreeCourseTime($duration)
{
    $hours = intdiv($duration, 60);
    $minuts = $duration % 60;

    return $hours . ' hrs ' . $minuts . ' minutos';
}

function getCompletedChapters($chapters)
{
    $completedChapters = $chapters->sum(function ($chapter) {
        if($chapter->progressUsers->first()){
            return $chapter->progressUsers->first()->pivot->status == 'F' ? 1 : 0;
        }
    });

    return $completedChapters;
}

function getShowSection(CourseSection $current_section, CourseSection $section)
{
    return $current_section->id == $section->id ? 'show' : '';
}

function getItsChapterFinished(SectionChapter $chapter, $allProgress)
{
    $progress = $allProgress->where('id', $chapter->id)->first();
    if ($progress) {
        return $progress->pivot->status == 'F' ? true : false;
    }
}

function getNFinishedChapters($section, $allProgress)
{
    $Nchapters = $allProgress->where('section_id', $section->id)
        ->sum(function ($chapter) {
            return $chapter->pivot->status == 'F' ? 1 : 0;
        });

    return $Nchapters;
}



// --------------- SURVEYS ------------------

function validateSurveys()
{
    $user = Auth::user();
    $surveys = $user->userSurveys()->whereHas('survey', function ($query) {
        $query->where('active', 'S');
    })
        ->with('survey:id,destined_to')
        ->get();

    $checkEmptyUserProfile = $surveys->filter(function ($survey) {
        return $survey->survey->destined_to == 'user_profile';
    })->isEmpty();

    if ($checkEmptyUserProfile && $user->profile_survey == 'N') {
        storeUserSurvey('user_profile', $user, NULL);
    }

    $checkPendingSurveys = $surveys->filter(function ($survey) {
        return $survey->status == 'pending';
    })->isNotEmpty();

    return $checkPendingSurveys;
}

function storeUserSurvey($destined_to, User $user, $event_id)
{
    $survey = Survey::where('destined_to', $destined_to)
                    ->where('active', 'S')
                    ->first();

    if ($survey != null) {
        return UserSurvey::create([
            'user_id' => $user->id,
            'survey_id' => $survey->id,
            "company_id" => $user->company_id,
            'date' => getCurrentDate(),
            'status' => 'pending',
            'start_time' => null,
            'end_time' => null,
            'total_time' => null,
            'event_id' => $event_id
            ]);
        }

    return false;
}

function getOptionsFromStatement(SurveyStatement $statement)
{
    $options = $statement->options->sortByDesc('description');

    return $options;
}

function getOptionsFromStatementAsc(SurveyStatement $statement)
{
    $options = $statement->options->sortBy('description');

    return $options;
}

function getChekedInput(SurveyStatement $statement, SurveyOption $option)
{
    return $statement->pivot->answer == $option->description ? 'checked' : '';
}

function verifyLastSurveyGroup($answersByGroup, $group_position)
{
    return $answersByGroup->count() == $group_position ? true : false;
}

function getProfileTypes(UserSurvey $userSurvey)
{
    $EC = 0;
    $OR = 0;
    $CA = 0;
    $EA = 0;

    foreach ($userSurvey->surveyAnswers as $surveyAnswer) {
        if(Str::contains( $surveyAnswer->pivot->answer,'(EC)') == '(EC)')
            $EC++;
        if(Str::contains( $surveyAnswer->pivot->answer,'(OR)') == '(OR)')
            $OR++;
        if(Str::contains( $surveyAnswer->pivot->answer,'(CA)') == '(CA)')
            $CA++;
        if(Str::contains( $surveyAnswer->pivot->answer,'(EA)') == '(EA)')
            $EA++;
    }

    return array(
        "EC" => $EC,
        "OR" => $OR,
        "CA" => $CA,
        "EA" => $EA
    );
}



// ---------------------------------------------




function getStatusClass($status)
{
    return ($status === 'S' ||
            $status === 1)  ? 'active' : '';
}

function getStatusText($status)
{
    return ($status === 'S' ||
            $status === 1)  ? 'Activo' : 'Inactivo';
}

function getStatusRecomended($status)
{
    return $status == 1
        ? '<i class="fa-solid fa-star flg-recom-btn active"></i>'
        : '<i class="fa-regular fa-star flg-recom-btn"></i>';
}

function getSelectedOption(CourseSection $section, $order)
{
    return $section->section_order == $order ? 'selected' : '';
}

function setSectionActive(CourseSection $section, $sectionActive)
{
    return $section->id == $sectionActive ? 'active' : '';
}

function getActiveSection($active)
{
    return $active != null ? $active : '';
}




// ---------- FILE -------------

function verifyUserAvatar($file)
{
    $url = asset('storage/img/user_avatar/default.png');

    if ($file) {
        $url = $file->file_url == null ? $url
        : $file->file_url;
    }

    return $url;
}

function verifyImage($file)
{
    $url = asset('storage/img/common/no-image.png');
    if ($file) {
        $url = $file->file_url == null ? $url
            : $file->file_url;

        // TARDA DEMASIADO CUANDO SON VARIAS IMÁGENES

        // $directory = (explode('/', str_ireplace(array('http://', 'https://'), '', $url)))[0];

        // if ($directory == 'localhost' || $directory == '127.0.0.1:8000') {
        //     $url = $url == null ? asset('storage/img/common/no-image.png')
        //         : $url;
        // } else {
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);

        //     curl_setopt($ch, CURLOPT_NOBODY, 1);
        //     curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //     $result = curl_exec($ch);
        //     curl_close($ch);
        //     if ($result == false) {
        //         $url = asset('storage/img/common/no-image.png');
        //     }
        // }
    }

    return $url;
}

function verifyFile($file)
{
    return $file != null ? $file->file_url : null;
}

//--------------------------------





// ----------- DATE TIME ------------

function getCurrentDate()
{
    return Carbon::now('America/Lima')->format('Y-m-d');
}

function getDiffForHumansFromTimestamp($timestamp)
{
    return Carbon::parse($timestamp)->diffForHumans();
}

function getTimeforHummans($time)
{
    return Carbon::parse($time)->format('g:i A');
}

function getCurrentYear()
{
    return Carbon::now('America/Lima')->format('Y');
}

function getCurrentMonth()
{
    return Carbon::now('America/Lima')->isoFormat('MMMM');
}

// ----------------------------------



function normalizeInputStatus($data)
{
    $data['active'] = isset($data['active']) ? 'S' : 'N';

    $data['flg_recom'] = isset($data['flg_recom']) ? 1 : 0;

    $data['status'] = isset($data['status']) ? 'S' : 'N';

    $data['flg_test_exam'] = isset($data['flg_test_exam']) ? 'S' : 'N';

    $data['flg_public'] = isset($data['flg_public']) ? 'S' : 'N';

    $data['flg_asist'] = isset($data['flg_asist']) ? 'S' : 'N';

    $data['flg_survey_course'] = isset($data['flg_survey_course']) ? 'S' : 'N';

    $data['flg_survey_evaluation'] = isset($data['flg_survey_evaluation']) ? 'S' : 'N';

    $data['assist_user'] = isset($data['assist_user']) ? 'S' : 'N';

    return $data;
}

function verifyEventType($type)
{
    switch ($type) {
        case 'present':
            $type = 'present';
            break;
        case 'P' :
            $type = 'present';
            break;
        case 'virtual':
            $type = 'virtual';
            break;
        case 'V' :
            $type = 'virtual';
            break;
        default:
            $type = '';
    }

    return $type;
}





/* ----------- HOME PAGE ------------*/


function getInstructorsFromCourseHome($course)
{
    $instructors = $course->events->map(function ($event) {
        return $event->user;
    })->unique();

    return $instructors;
}


function getAllCapacity($course)
{
    $capacity = $course->events->sum(function ($event){
        return $event->room->capacity;
    });

    return $capacity;
}

function getCountAllParticipants($course)
{
    $participant = $course->events->sum(function ($event){
        return $event->participants_count;
    });

    return $participant;
}

// ------------------------------------


function getCleanArrayAnswers($string)
{
    return array_map(function ($x) {
        return trim(strtoupper($x));
    }, explode(',', $string));
}






function getFileExtension(ModelsFile $file)
{
    $pathToFile = $file->file_url;

    $fileExt = FacadesFile::extension($pathToFile);

    switch ($fileExt) {
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
