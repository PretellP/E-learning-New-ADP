<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MiningUnit extends Model
{
    use HasFactory;

    protected $table = 'mining_units';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'mining_units_users', 'mining_unit_id', 'user_id');
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'certifications_mining_units', 'mining_unit_id', 'certification_id')
                    ->withTimestamps();
    }
}
