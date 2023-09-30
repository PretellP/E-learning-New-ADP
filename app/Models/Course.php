<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Folder,
    Exam,
    CourseCategory,
    CourseSection,
    SectionChapter,
    File,
    Certification
};

class Course extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    use HasFactory;

    protected $table = 'courses';
    protected $fillable = [
        'description',
        'subtitle',
        'date',
        'hours',
        'time_start',
        'time_end',
        'active',
        'course_type',
        'flg_public',
        'flg_recom',
        'category_id'
    ];

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

    public function courseChapters()
    {
        return $this->hasManyThrough(SectionChapter::class, CourseSection::class, 'course_id', 'section_id');
    }

    public function courseCertifications()
    {
        return $this->hasManyDeep(Certification::class, [Exam::class, Event::class])
                    ->withIntermediate(Event::class, ['id','exam_id','user_id']);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function loadCourseImage()
    {
        return $this->loadMissing([
            'file' => fn ($query) =>
            $query->where('file_type', 'imagenes')
                ->where('category', 'cursos')
        ]);
    }

    public function loadFreeCourseImage()
    {
        return $this->load([
            'file' => fn ($query2) =>
            $query2->where('file_type', 'imagenes')
                ->where('category', 'cursoslibres')
        ]);
    }

    public function loadFreeCourseRelationships()
    {
        return $this->load(
            [
                'courseCategory',
                'courseSections' => fn ($query) =>
                $query->orderBy('section_order', 'ASC')
                    ->withCount('sectionChapters'),
                'file' => fn ($query2) =>
                $query2->where('file_type', 'imagenes')
                    ->where('category', 'cursoslibres')
            ]
        )->loadCount(['courseSections', 'courseChapters'])
            ->loadSum('courseChapters', 'duration');
    }

    public function getSectionLastOrder()
    {
        $this->loadMax('courseSections', 'section_order'); 

        return $this->course_sections_max_section_order == null ?
                 0 : $this->course_sections_max_section_order;
    }
}
