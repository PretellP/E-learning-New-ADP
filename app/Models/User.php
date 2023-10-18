<?php

namespace App\Models;

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
        'dni', 'name',
        'paternal', 'maternal', 'email',
        'password', 'telephone', 'role', 
        'cip', 'signature', 'active',
        'company_id', 'position', 'profile_survey',
        'profile_user'
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

    public function participantEvents()
    {
        return $this -> belongsToMany(Event::class, Certification::class, 'user_id', 'event_id')->withTimestamps();
    }

    public function responsableEvents()
    {
        return $this -> hasMany(Events::class, 'responsable_id', 'id');
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
        return $this -> hasMany(UserSurvey::class, 'user_id', 'id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    static function getInstructorsQuery()
    {
        return User::whereIn('role', ['instructor']);
    }

    static function getResponsablesQuery()
    {
        return User::where('company_id', 10);
    }

    public function avatar()
    {
        return $this->file()->where('category', 'avatars')->first();
    }

    public function signature()
    {
        return $this->file()->where('category', 'firmas')->first();
    }

    public function loadAvatar()
    {
        return $this->load(['file' => fn($q) => 
            $q->where('category', 'avatars')
        ]);
    }


    
    /* ----------- ACCESSORS ------------*/


    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->paternal;
    }

    public function getFullNameCompleteAttribute()
    {
        return $this->name . ' ' . $this->paternal . ' ' . $this->maternal;
    }

    public function getFullNameCompleteReverseAttribute()
    {
        return $this->paternal . ' ' . $this->maternal  . ', ' . $this->name;
    }
}
