<?php

namespace App\Services\Reports;

use App\Models\{UserSurvey};
use App\Services\Classroom\ClassroomSurveyService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProfileSurveyService
{
    public function getDataTable(Request $request)
    {
        $query = UserSurvey::with([
            'user',
            'survey',
            'surveyAnswers',
            'company'
        ])
        ->whereHas('survey', function ($q) {
            $q->where('destined_to', 'user_profile');
        })
        ->where('status', 'finished')
        ->select('users_surveys.*');

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $query = $query->whereBetween('end_time', [$request->from_date, $request->end_date]);
        }

        $allProfileSurveys = DataTables::of($query)
            ->editColumn('company.description', function ($userSurvey) {
                return $userSurvey->company == null ? '-' : $userSurvey->company->description;
            })
            ->editColumn('end_time', function ($userSurvey) {
                return $userSurvey->end_time;
            })
            ->addColumn('ec', function ($userSurvey) {
                return (app(ClassroomSurveyService::class)->getProfileTypes($userSurvey))['EC'];
            })
            ->addColumn('or', function ($userSurvey) {
                return (app(ClassroomSurveyService::class)->getProfileTypes($userSurvey))['OR'];
            })
            ->addColumn('ca', function ($userSurvey) {
                return (app(ClassroomSurveyService::class)->getProfileTypes($userSurvey))['CA'];
            })
            ->addColumn('ea', function ($userSurvey) {
                return (app(ClassroomSurveyService::class)->getProfileTypes($userSurvey))['EA'];
            })
            ->make(true);

        return $allProfileSurveys;
    }
}