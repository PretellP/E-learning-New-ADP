<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyStatement;

class SurveyOption extends Model
{
    use HasFactory;
    protected $table = 'options';
    protected $guarded = [];

    public function statement()
    {
        return $this->belongsTo(SurveyStatement::class, 'statement_id', 'id');
    }
}
