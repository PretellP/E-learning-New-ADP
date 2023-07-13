<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    public function events()
    {
        return $this -> hasMany(Event::class, 'room_id', 'id');
    }
}
