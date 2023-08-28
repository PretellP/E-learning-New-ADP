<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Event, Evaluation, User};

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certifications';
    protected $guarded = [];

    public function event()
    {
        return $this -> belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this -> belongsTo(User::class, 'user_id', 'id');
    }

    public function evaluations()
    {       
        return $this -> hasMany(Evaluation::class, 'certification_id', 'id');
    }

}
