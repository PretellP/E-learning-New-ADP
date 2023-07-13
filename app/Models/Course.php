<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Folder, Exam};

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public function folders()
    {
        return $this->hasMany(Folder::class, 'id_course', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'course_id', 'id');
    }
}

