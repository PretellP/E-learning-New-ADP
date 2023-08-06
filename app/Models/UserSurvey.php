<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Survey, Course, SurveyStatement};

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

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function surveyAnswers()
    {
        return $this->belongsToMany(SurveyStatement::class, 'survey_answers', 'user_survey_id', 'statement_id')
                                ->withPivot(['id', 'answer', 'statement'])->withTimestamps();
    }
    
}
