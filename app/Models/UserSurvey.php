<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Survey, Event, SurveyStatement};

class UserSurvey extends Model
{
    use HasFactory;
    protected $table = 'users_surveys';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function surveyAnswers()
    {
        return $this->belongsToMany(SurveyStatement::class, 'survey_answers', 'user_survey_id', 'statement_id')
                                ->withPivot(['id', 'answer', 'statement'])->withTimestamps();
    }
    
    public function loadRelationships()
    {
        return $this->load(
            [
                'survey' => fn($q) => $q->select('id', 'name', 'destined_to'),
                'surveyAnswers' => fn($q2) => $q2->with([
                        'group:id,name,description,survey_id',
                        'options:id,description,statement_id',   
                        ])
                        ->select('statements.id',
                                'statements.description',
                                'statements.group_id',
                                'statements.desc',
                                'statements.type')
            ]
        );
    }
}
