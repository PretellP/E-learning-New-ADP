<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Certification, 
                Event, 
                Company,
                MiningUnit,
                Publishing,
                SectionChapter,
                UserSurvey
            };

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function certifications()
    {
        return $this -> hasMany(Certification::class, 'user_id', 'id');
    }

    public function events()
    {
        return $this -> hasMany(Event::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this -> belongsTo(Company::class, 'company_id', 'id');
    }

    public function miningUnits()
    {
        return $this -> belongsToMany(MiningUnit::class, 'mining_units_users', 'user_id', 'mining_unit_id');
    }

    public function publishings()
    {
        return $this -> hasMany(Publishing::class, 'user_id', 'id');
    }

    public function progressChapters()
    {
        return $this -> belongsToMany(SectionChapter::class, 'user_course_progress', 'user_id', 'section_chapter_id')
                                        ->withPivot(['id', 'progress_time', 'last_seen', 'status'])->withTimestamps();
    }

    public function userSurveys()
    {
        return $this->hasMany(UserSurvey::class, 'user_id', 'id');
    }

}
