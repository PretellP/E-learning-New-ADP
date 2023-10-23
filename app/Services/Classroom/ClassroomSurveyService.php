<?php

namespace App\Services\Classroom;

use App\Models\{Survey, User, UserSurvey};
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ClassroomSurveyService 
{
    public function getPendingSurveys(User $user)
    {
        $pendingSurveys = $user->userSurveys()->where('status', 'pending')
                                ->whereHas('survey', function($query){
                                    $query->where('active', 'S');
                                })
                                ->with(['survey' => fn ($query) => 
                                    $query->with('file')
                                        ->select('id', 'name', 'destined_to', 'active')
                                ])
                                ->get();

        return $pendingSurveys;
    }

    // ------------- START EVALUATION ---------------

    public function getSurveyNumQuestion(UserSurvey $userSurvey)
    {
        $answers = $userSurvey->surveyAnswers;
       
        $num_question = 1;

        if($answers->isEmpty())
        {
            $this->startSurvey($userSurvey);
        }
        else{
            $num_question = ($answers->filter(function($answer){
                                return $answer->pivot->answer != null;
                            })->count()) + 1;
        }

        return $num_question;
    }

    private function startSurvey(UserSurvey $userSurvey) : void
    {
        $userSurvey->load('survey.surveyGroups.statements');

        $statements = $this->getStatementsFromUserSurvey($userSurvey);
            
        $userSurvey->update([
            'start_time' => Carbon::now('America/Lima')
        ]);

        foreach($statements as $key => $statement)
        {
            $userSurvey->surveyAnswers()->attach($statement, [
                'statement' => $statement->description,
                'answer' => null,
                'question_order' => $key+1,
            ]);
        }
    }

    public function getStatementsFromUserSurvey(UserSurvey $userSurvey)
    {
        $statements = $userSurvey->survey
                    ->surveyGroups->map(function ($group) {
                        return $group->statements;
                    })->flatten();
    
        return $statements;
    }


    // --------------- SHOW EVALUATION ------------------

    /** 
    * @return bool 
    **/
    public function isEnableEvaluation(UserSurvey $userSurvey, User $user, $num_question)
    {
        $answers = $userSurvey->surveyAnswers;
        $answered = $answers->filter(function($statement){
                                return $statement->pivot->answer != null;
                            })->count();
        
        return $userSurvey->status != 'finished' && 
                $userSurvey->user_id == $user->id &&
                (!($answered < $num_question-1));
    }

    public function getShowSurveyData(UserSurvey $userSurvey, $num_question)
    {
        $survey = $userSurvey->survey;
        $answers = $userSurvey->surveyAnswers;

        $answers_by_group = $answers->groupBy('group.id');
        $current_group = $answers_by_group[$answers[$num_question-1]->group->id]->sortByDesc('type');
        $group_id = $current_group->first()->group->id;

        $group_position = $this->getGroupPosition($answers_by_group, $group_id);
        $previous_group = $this->getPreviousGroup($answers_by_group, $group_id);
        $previous_num_question = $this->getPreviousNumQuestion($previous_group, $answers);
        $group_options = $this->getGroupOptions($survey, $current_group);

        return array(
            "survey" => $survey,
            "answers_by_group" => $answers_by_group,
            "group_position" => $group_position,
            "group_id" => $group_id,
            "current_group" => $current_group,
            "group_options" => $group_options,
            "previous_num_question" => $previous_num_question
        );
    }

    private function getGroupPosition($answers, $group_id)
    {
        $position = 0;

        foreach ($answers as $group)
        {
            $position++;
            if($group->first()->group->id == $group_id){
                break;
            }
        }

        return $position;
    }

    private function getPreviousGroup($answers, $group_id)
    {
        return $answers->takeUntil(function($group) use($group_id){
                return $group->first()->group->id == $group_id;
            })->last();
    }

    private function getPreviousNumQuestion($previous_group, $answers)
    {
        // $previous_num_question = NULL;

        if($previous_group != null)
        {   
            $last_statement_id = $previous_group->first()->id;
            $previous_num_question = ($answers->takeUntil(function($statement) use($last_statement_id){
                                        return $statement->id == $last_statement_id;
                                    }))->count() + 1;
        }

        return $previous_num_question ?? NULL;
    }

    private function getGroupOptions(Survey $survey, $current_group)
    {
        if($survey->destined_to == 'course_live')
        {
            $group_options = $current_group->pluck('options')
                                            ->flatten()
                                            ->pluck('description')
                                            ->unique()
                                            ->sortByDesc('description');
        }

        return $group_options ?? NULL;
    }

    // ------------------ UPDATE -----------------------

    public function updateAnswers(Request $request, UserSurvey $userSurvey, $statements)
    {        
        foreach($statements as $statement)
        {
            $userSurvey->surveyAnswers()->updateExistingPivot($statement, [
                'answer' => $request['option-'.$statement->id]
            ]);
        }  
    }

    public function endSurvey(UserSurvey $userSurvey)
    {
        $end_time = Carbon::now('America/Lima');
        $start_time = Carbon::parse($userSurvey->start_time);
        $total_time = intdiv($start_time->diffInSeconds($end_time), 60);

        return $userSurvey->update([
            'status' => 'finished',
            'end_time' => $end_time,
            'total_time' => $total_time
        ]);
    }

}