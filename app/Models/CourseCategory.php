<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{Course, File};

class CourseCategory extends Model
{
    use HasFactory;

    protected $table = 'course_categories';
    protected $fillable = [
        'description', 'status', 'url_img'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function loadImage()
    {
        return $this->load(
            [
                'file' => fn ($query) =>
                $query->where('file_type', 'imagenes')
            ]
        );
    }
}
