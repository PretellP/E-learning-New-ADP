<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Course, SectionChapter};

class CourseSection extends Model
{
    use HasFactory;

    protected $table = 'course_sections';
    protected $guarded = [];

    public function course()
    {
        return $this -> belongsTo(Course::class, 'course_id', 'id');
    }

    public function sectionChapters()
    {
        return $this -> hasMany(SectionChapter::class, 'section_id', 'id');
    }

}
