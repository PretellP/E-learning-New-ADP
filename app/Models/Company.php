<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    public function users()
    {
        return $this -> HasMany(User::class, 'company_id', 'id');
    }
}
