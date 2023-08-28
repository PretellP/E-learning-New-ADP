<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{DynamicQuestion, DroppableOption};

class DynamicAlternative extends Model
{
    use HasFactory;

    protected $table = 'dynamic_alternatives';
    protected $guarded = [];


    public function question()
    {
        return $this -> belongsTo(DynamicQuestion::class, 'dynamic_question_id', 'id');
    }

    public function droppableOptions()
    {
        return $this -> hasMany(DroppableOption::class, 'dynamic_alternative_id', 'id');
    }
}
