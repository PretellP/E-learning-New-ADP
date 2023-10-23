<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{SurveyGroup, UserSurvey};

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';
    protected $fillable = [
        'name',
        'destined_to',
        'active'
    ];

    public function surveyGroups()
    {
        return $this->hasMany(SurveyGroup::class, 'survey_id', 'id');
    }

    public function statements()
    {
        return $this->hasManyThrough(SurveyStatement::class, SurveyGroup::class, 'survey_id', 'group_id');
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class, 'survey_id', 'id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function loadImage()
    {
        return $this->load(['file' => fn($q) => $q->where('file_type', 'imagenes')]);
    }

    public function loadRelationships()
    {
        return $this->load([
            'file' => fn($q) => $q->where('file_type', 'imagenes'),
        ])
        ->loadCount(['surveyGroups', 'statements']);
    }
}
