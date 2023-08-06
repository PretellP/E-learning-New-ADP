<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{SurveyGroup, SurveyOption, UserSurvey};

class SurveyStatement extends Model
{
    use HasFactory;
    protected $table = 'statements';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(SurveyGroup::class, 'group_id','id');
    }

    public function options()
    {
        return $this->hasMany(SurveyOption::class, 'statement_id', 'id');
    }

    public function usersAnswers()
    {
        return $this->belongsToMany(UserSurvey::class, 'survey_answers', 'statement_id', 'user_survey_id')
                                ->withPivot(['id', 'answer', 'statement', 'question_order'])->withTimestamps();
    }
}
