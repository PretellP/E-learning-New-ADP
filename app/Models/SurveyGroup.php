<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Survey, SurveyStatement};

class SurveyGroup extends Model
{
    use HasFactory;
    protected $table = 'survey_groups';
    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }

    public function statements()
    {
        return $this->hasMany(SurveyStatement::class, 'group_id', 'id');
    }
}
