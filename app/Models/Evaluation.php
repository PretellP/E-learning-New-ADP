<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certification;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';
    protected $guarded = [];


    public function certification()
    {
        return $this -> belongsTo(Certification::class, 'certification_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(DynamicQuestion::class, 'question_id', 'id');
    }

}
