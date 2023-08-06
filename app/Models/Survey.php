<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{SurveyGroup, UserSurvey};

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';
    protected $guarded = [];

    public function surveyGroups()
    {
        return $this->hasMany(SurveyGroup::class, 'survey_id', 'id');
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class, 'survey_id','id');
    }
}
