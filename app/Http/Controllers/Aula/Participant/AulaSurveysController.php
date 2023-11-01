<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserSurvey};
use App\Services\Classroom\{ClassroomSurveyService};
use Auth;

class AulaSurveysController extends Controller
{
    private $surveyService;

    public function __construct(ClassroomSurveyService $service)
    {
        $this->surveyService = $service;
    }

    public function index()
    {
        $user = Auth::user();
       
        $pendingSurveys = $this->surveyService->getPendingSurveys($user);

        return view('aula.viewParticipant.surveys.index', [
            'pendingSurveys' => $pendingSurveys
        ]);
    }

    public function start(UserSurvey $userSurvey)
    {
        $userSurvey->load(['survey', 'surveyAnswers']);

        $num_question = $this->surveyService->getSurveyNumQuestion($userSurvey);

        return redirect()->route('aula.surveys.show', [
            'user_survey' => $userSurvey,
            'num_question' => $num_question,
        ]);
    }

    public function show(UserSurvey $userSurvey, $num_question)
    {
        $user = Auth::user();

        $userSurvey->loadRelationships();

        if ($this->surveyService->isEnableEvaluation($userSurvey, $user, $num_question))
        {
            $surveyData = $this->surveyService->getShowSurveyData($userSurvey, $num_question);

            return view('aula.viewParticipant.surveys.show', [
                'survey' => $surveyData['survey'],
                'user_survey' => $userSurvey,
                'answersByGroup' => $surveyData['answers_by_group'],
                'group_position' => $surveyData['group_position'],
                'group_id' => $surveyData['group_id'],
                'current_group' => $surveyData['current_group'],
                'group_options' => $surveyData['group_options'],
                'previous_num_question' => $surveyData['previous_num_question']
            ]);
        }

        abort(403, 'Acceso Denegado');
    }

    public function update(Request $request, UserSurvey $user_survey, $group_id)
    {
        $user_survey->loadRelationships();
        $answers = $user_survey->surveyAnswers;
        $statements = ($answers->groupBy('group.id'))[$group_id];
        
        $this->surveyService->updateAnswers($request, $user_survey, $statements, $group_id);

        $next_num_statement = ($answers->takeUntil(function ($statement) use($group_id){
                                return $statement->group->id == $group_id;
                            })->count()) + $statements->count() + 1;

        if(isset($answers[$next_num_statement-1]))
        {
            return redirect()->route('aula.surveys.show', [
                'user_survey' => $user_survey,
                'num_question' => $next_num_statement
            ]);
        }

        $this->surveyService->endSurvey($user_survey);

        if ($user_survey->event != null) {
            return redirect()->route('aula.course.evaluation.index', ["course" => $user_survey->event->course]);
        }

        return redirect()->route('aula.surveys.index');
    }

}
