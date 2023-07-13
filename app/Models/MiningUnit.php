<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MiningUnit extends Model
{
    use HasFactory;

    protected $table = 'mining_units';

    public function users()
    {
        return $this -> belongsToMany(User::class, 'mining_units_users', 'mining_unit_id', 'user_id');
    }
}
