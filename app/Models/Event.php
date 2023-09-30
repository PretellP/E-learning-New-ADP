<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Exam, Certification, User, Room};

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = [
        'description',
        'type',
        'date',
        'active',
        'flg_test_exam',
        'flg_asist',
        'flg_survey_course',
        'flg_survey_evaluation',
        'exam_id',
        'test_exam_id',
        'elearning_id',
        'user_id',
        'responsable_id',
        'room_id',
        'security_id',
        'flg_security',
        'security_por_id',
        'flg_security_por',
        'owner_companies_id',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function testExam()
    {
        return $this->belongsTo(Exam::class, 'test_exam_id', 'id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class, 'event_id', 'id');
    }

    public function eLearning()
    {
        return $this->belongsTo(Elearning::class, 'elearning_id', 'id');
    }

    public function ownerCompany()
    {
        return $this->belongsTo(OwnerCompany::class, 'owner_companies_id', 'id');
    }

    public function loadRelationships()
    {
        return $this->load([
            'user',
            'responsable',
            'exam',
            'testExam',
            'ownerCompany',
            'room',
            'eLearning',
        ])
        ->loadCount(['certifications', 'userSurveys']);
    }
}
