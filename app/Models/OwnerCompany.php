<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;

class OwnerCompany extends Model
{
    use HasFactory;

    protected $table = 'owner_companies';

    public function exams()
    {
        return $this -> hasMany(Exam::class, 'owner_company_id', 'id');
    }
}
