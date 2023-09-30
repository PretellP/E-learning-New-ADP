<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Course, SectionChapter};

class CourseSection extends Model
{
    use HasFactory;

    protected $table = 'course_sections';
    protected $fillable = [
        'title',
        'section_order',
        'course_id'
    ];

    public function course()
    {
        return $this -> belongsTo(Course::class, 'course_id', 'id');
    }

    public function sectionChapters()
    {
        return $this -> hasMany(SectionChapter::class, 'section_id', 'id');
    }

    public function getChapterLastOrder()
    {
        $this->loadMax('sectionChapters', 'chapter_order');

        return $this->section_chapters_max_chapter_order == null ? 0 :
                $this->section_chapters_max_chapter_order;
    }
}
