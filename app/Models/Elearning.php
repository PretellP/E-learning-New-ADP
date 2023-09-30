<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elearning extends Model
{
    use HasFactory;

    protected $table = 'e_learnings';

    public function events()
    {
        return $this -> hasMany(Event::class, 'elearning_id', 'id');
    }
}
