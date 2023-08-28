<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Folder, Exam, CourseCategory, CourseSection, UserSurvey};

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $guarded = [];

    public function folders()
    {
        return $this->hasMany(Folder::class, 'id_course', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'course_id', 'id');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id');
    }

    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id');
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class, 'course_id', 'id');
    }
}

