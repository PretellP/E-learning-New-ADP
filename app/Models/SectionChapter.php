<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{CourseSection, User};

class SectionChapter extends Model
{
    use HasFactory;
    
    protected $table = 'section_chapters';
    protected $guarded = [];

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'id');
    }

    public function progressUsers()
    {
        return $this->belongsToMany(User::class, 'user_course_progress', 'section_chapter_id', 'user_id')
                                    ->withPivot(['id', 'progress_time', 'last_seen', 'status'])->withTimestamps();
    }
    
}
