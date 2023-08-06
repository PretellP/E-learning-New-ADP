<?php

namespace App\Http\Controllers\Aula\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserSurvey, Survey, SurveyStatement};
use Auth;
use Carbon\Carbon;

class AulaSurveysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pendingSurveys = $user->userSurveys()->where('status', 'pending')
                                            ->whereHas('survey', function($query){
                                                $query->where('active', 'S');
                                            })
                                            ->with('survey:id,name,destined_to,url_img,active')
                                            ->get();

        return view('aula2.viewParticipant.surveys.index', [
            'pendingSurveys' => $pendingSurveys
        ]);
    }


    public function start(UserSurvey $userSurvey)
    {
        $answers = $userSurvey->surveyAnswers;
        $num_question = 1;

        if($answers->isEmpty())
        {
            $statements = getStatementsFromUserSurvey($userSurvey);

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
        else{
            $num_question = ($answers->filter(function($answer){
                                return $answer->pivot->answer != null;
                            })->count()) + 1;
        }

        return redirect()->route('aula.surveys.show', [
            'user_survey' => $userSurvey,
            'num_question' => $num_question,
        ]);
    }


    public function show(UserSurvey $userSurvey, $num_question)
    {
        $user = Auth::user();

        if($userSurvey->status == 'finished' || $userSurvey->user_id != $user->id)
        {
            abort(403, 'Acceso Denegado');
        }
        else
        {
            $survey = $userSurvey->survey()->select('id','name','destined_to')->first();

            $answers = $userSurvey->surveyAnswers()->with('group:id,name,description,survey_id')
                                                    ->with('options:id,description,statement_id')
                                                    ->select('statements.id',
                                                            'statements.description',
                                                            'statements.group_id',
                                                            'statements.desc',
                                                            'statements.type')
                                                    ->get();

            $answered = $answers->filter(function($statement){
                                    return $statement->pivot->answer != null;
                                })->count();

            if(!($answered < $num_question-1))
            {
                if($survey->destined_to == 'course_live')
                {
                    $answersByGroup = $answers->groupBy('group.id');
                    $current_group = $answersByGroup[$answers[$num_question-1]->group->id];
                    $group_position = 0;
                    $group_id = $current_group->first()->group->id;
                    $previous_num_question = null;
                    
                    foreach($answersByGroup as $group)
                    {
                        $group_position++;
                        if($group->first()->group->id == $group_id){
                            break;
                        }
                    }
        
                    $previous_group = $answersByGroup->takeUntil(function($group) use($group_id){
                                                return $group->first()->group->id == $group_id;
                                            })->last();
        
                    if($previous_group != null)
                    {   
                        $last_statement_id = $previous_group->first()->id;
                        $previous_num_question = ($answers->takeUntil(function($statement) use($last_statement_id){
                                                    return $statement->id == $last_statement_id;
                                                }))->count() + 1;
                    }
        
                    $group_options = $current_group->pluck('options')
                                                    ->flatten()
                                                    ->pluck('description')
                                                    ->unique()
                                                    ->sortByDesc('description');
                    
                    return view('aula2.viewParticipant.surveys.show', [
                        'survey' => $survey,
                        'user_survey' => $userSurvey,
                        'answersByGroup' => $answersByGroup,
                        'group_position' => $group_position,
                        'group_id' => $group_id,
                        'current_group' => $current_group,
                        'group_options' => $group_options,
                        'previous_num_question' => $previous_num_question
                    ]);
                }
                else{
                    $statement = $answers[$num_question-1];
        
                    return view('aula2.viewParticipant.surveys.show', [
                        'survey' => $survey,
                        'user_survey' => $userSurvey,
                        'statement' => $statement,
                        'answers' => $answers,
                        'num_question' => $num_question
                    ]);
                }
            }
            else
            {
                abort(403, 'Acceso Denegado');
            }
    
            
        }
    }


    public function update(Request $request, UserSurvey $user_survey, $group_id)
    {
        $survey = $user_survey->survey;

        $answers = $user_survey->surveyAnswers()->with('group:id,survey_id')
                                                ->select('statements.id',
                                                        'statements.group_id')
                                                ->get();
        if($survey->destined_to == 'course_live')
        {
            $statements = ($answers->groupBy('group.id'))[$group_id];

            $next_num_question = ($answers->takeUntil(function ($statement) use($group_id){
                                    return $statement->group->id == $group_id;
                                })->count()) + $statements->count() + 1;

            foreach($statements as $statement)
            {
                $user_survey->surveyAnswers()->updateExistingPivot($statement, [
                    'answer' => $request['option-'.$statement->id]
                ]);
            }  
        }

        if(isset($answers[$next_num_question-1]))
        {
            return redirect()->route('aula.surveys.show', [
                'user_survey' => $user_survey,
                'num_question' => $next_num_question
            ]);
        }
        else
        {
            $end_time = Carbon::now('America/Lima');
            $start_time = Carbon::parse($user_survey->start_time);
            $total_time = intdiv($start_time->diffInSeconds($end_time), 60);

            $user_survey->update([
                'status' => 'finished',
                'end_time' => $end_time,
                'total_time' => $total_time
            ]);

            return redirect()->route('aula.surveys.index');
        }  
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
