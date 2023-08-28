<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Exam, Certification, User, Room};

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this -> belongsTo(User::class, 'user_id', 'id');
    }

    public function room()
    {
        return $this -> belongsTo(Room::class, 'room_id', 'id');
    }
}
