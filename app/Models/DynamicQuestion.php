<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Exam, 
    DynamicAlternative,
    QuestionType,
    File
};

class DynamicQuestion extends Model
{
    use HasFactory;
   
    protected $table = 'dynamic_questions';
    protected $fillable = [
        'statement',
        'points',
        'exam_id',
        'question_type_id'
    ];


    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id', 'id');
    }

    public function alternatives()
    {
        return $this->hasMany(DynamicAlternative::class, 'dynamic_question_id', 'id');
    }

    public function droppableOptions()
    {
        return $this->hasManyThrough(DroppableOption::class, DynamicAlternative::class, 'dynamic_question_id', 'dynamic_alternative_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function loadRelationships()
    {
        return $this->load(
            [
                'files',
                'exam',
                'questionType', 
                'alternatives' => fn ($query) => 
                    $query->with(['file', 'droppableOption'])
            ]);
    }

    public function getCleanStatementAttribute()
    {
        return str_replace('[ ___________ ]', ' ___________ ', $this->statement);
    }
}
