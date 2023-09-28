<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{DynamicQuestion, DroppableOption};

class DynamicAlternative extends Model
{
    use HasFactory;

    protected $table = 'dynamic_alternatives';
    protected $fillable = [
        'description',
        'is_correct',
        'dynamic_question_id'
    ];


    public function question()
    {
        return $this -> belongsTo(DynamicQuestion::class, 'dynamic_question_id', 'id');
    }

    public function droppableOptions()
    {
        return $this -> hasOne(DroppableOption::class, 'dynamic_alternative_id', 'id');
    }

    public function file()
    {
        return $this -> morphOne(File::class, 'fileable');
    }

    public function loadImage()
    {
        return $this->load([
            'file' => fn ($query) =>
            $query->where('file_type', 'imagenes')
        ]);
    }
}
