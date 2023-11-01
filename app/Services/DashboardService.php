<?php

namespace App\Services;

use App\Models\{Certification, Course, User};
use Carbon\Carbon;
use DB;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class DashboardService
{

    // * Alumnos desaprobados y Alumnos aprobados

    public function getFinishedCertifications(){

        $start = Carbon::now()->startOfMonth();

        return Certification::whereHas('event', function($query) use($start) { $query->whereBetween('date', [ $start, getCurrentDate()]) ;})
            ->where('evaluation_type', 'certification')->where('status', 'finished')
            ->with('event:id,min_score')
            ->get(['id', 'event_id', 'score']);
    }

    public function getStatusEvaluations(){

        $finishedCertifications = $this->getFinishedCertifications();

        $approved = $finishedCertifications->filter(function ($certification) {
            return $certification->score >= $certification->event->min_score;
        })->count();

        $suspended = $finishedCertifications->filter(function ($certification) {
            return $certification->score < $certification->event->min_score;
        })->count();

        return [
            'approved' => $approved,
            'suspended' => $suspended,
        ];

    }

    // * Tipos de usuarios

    public function getTypeRole(){

        $roles = config('parameters.roles');

        $roleCounts = [];

        foreach ($roles as $roleKey => $roleName) {

            $clave = str_replace(' ', '', $roleName);

            $roleCounts[$clave] = User::where('role', $roleKey)->count();

        }

        return json_encode($roleCounts);
    }




}
