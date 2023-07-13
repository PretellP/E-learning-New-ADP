<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    DynamicQuestion,
    Event,
    Course,
    OwnerCompany};

class Exam extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(DynamicQuestion::class, 'exam_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'exam_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function ownerCompany()
    {
        return $this->belongsTo(OwnerCompany::class, 'owner_company_id', 'id');
    }

}
