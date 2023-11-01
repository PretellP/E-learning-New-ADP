<?php

namespace App\Services\Classroom;

use App\Models\{Certification, Survey, User, UserSurvey};
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ClassroomQuizService 
{
    public function getEnabledUserSurvey(Certification $certification)
    {
        $event = $certification->event;

        if ($event->flg_survey_course == 'S' || $event->flg_survey_evaluation == 'S') {

            return app(ClassroomSurveyService::class)->getFirstUserSurvey($event);
        }

        return null;
    }

}