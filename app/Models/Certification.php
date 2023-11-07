<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Event, Evaluation, User};

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certifications';
    protected $fillable = [
        'assist_user',
        'recovered_at',
        'status',
        'user_id',
        'event_id',
        'company_id',
        'position',
        'evaluation_type',
        'evaluation_time',
        'test_certification_id',
        'start_time',
        'end_time',
        'total_time',
        'score',
        'score_fin',
        'area',
        'observation'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'certification_id', 'id');
    }

    public function testCertification()
    {
        return $this->belongsTo(self::class, 'test_certification_id', 'id');
    }

    // public function miningUnits()
    // {
    //     return $this->belongsToMany(MiningUnit::class, 'certifications_mining_units', 'certification_id', 'mining_unit_id')->withTimestamps();
    // }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function loadRelationships()
    {
        return $this->load([
            'user' => fn ($query) =>
                    $query->with(['company']),
            'event' => fn ($q) =>
                $q->with(['exam' => fn($q2) =>
                            $q2->withCount('questions')
                                ->withAvg('questions', 'points')
                        , 'course']), 
            'company'
        ]);
    }

    public function getIsEnableEvaluationAttribute()
    {
        $messages = [];
        $now = getCurrentDate();

        if ($this->user->active != 'S') array_push($messages, "No está activo.");
        // if($this->user->signature != 'S') array_push($messages, "No tiene firma.");
        if ($this->assist_user != 'S') array_push($messages, "No tiene asistencia.");
        if ($this->event->date != $now) array_push($messages, "Fuera de fecha.");
        if ($this->status == 'finished') array_push($messages, "Finalizó evaluación.");

        return count($messages) > 0 ? $messages : ["Habilitado"];
    }

    public function getValidAssistCheckedAttribute()
    {
        return $this->assist_user == 'S' ? 'checked' : '';
    }

    public function getEventAssistStatusAttribute()
    {
        return $this->event->flg_asist != 'S' ||
            $this->status == 'finished' ? 'disabled' : '';
    }
}
