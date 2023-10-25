<?php

namespace App\Services\Reports;

use App\Models\{UserSurvey};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserSurveyService
{
    public function getDataTable(Request $request)
    {
        $query = UserSurvey::with([
            'user',
            'event.user',
            'event.course',
            'survey',
            'surveyAnswers',
            'company'
        ])
        ->where('status', 'finished');

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $query = $query->whereBetween('end_time', [$request->from_date, $request->end_date]);
        }

        $allUserSurveys = DataTables::of($query)
            ->editColumn('end_time', function ($userSurvey) {
                return $userSurvey->end_time;
            })
            ->editColumn('event.user.name', function ($userSurvey) {
                return $userSurvey->event != null ? $userSurvey->event->user->full_name :
                                                    'No hay registros';
            })
            ->editColumn('event.course.description', function ($userSurvey) {
                return $userSurvey->event != null ? $userSurvey->event->course->description :
                                                    'No hay registros';
            })
            ->make(true);

        return $allUserSurveys;
    }
}