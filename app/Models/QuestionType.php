<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicQuestion;

class QuestionType extends Model
{
    use HasFactory;
    protected $table = 'question_types';
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(DynamicQuestion::class, 'question_type_id', 'id');
    }
}
