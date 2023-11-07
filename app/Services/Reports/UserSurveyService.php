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
        ->where('status', 'finished')
        ->select('users_surveys.*');

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $query = $query->whereBetween('end_time', [$request->from_date, $request->end_date]);
        }

        $allUserSurveys = DataTables::of($query)
            ->editColumn('end_time', function ($userSurvey) {
                return $userSurvey->end_time;
            })
            ->editColumn('company.description', function ($userSurvey) {
                return $userSurvey->company == null ? '-' : $userSurvey->company->description;
            })
            ->editColumn('event.user.name', function ($userSurvey) {
                return $userSurvey->event != null ? $userSurvey->event->user->full_name :
                                                    'No hay registros';
            })
            ->editColumn('event.course.description', function ($userSurvey) {
                return $userSurvey->event != null ? $userSurvey->event->course->description :
                                                    'No hay registros';
            })
            ->addColumn('action', function ($userSurvey) {
                $btn = '<a href="javascript:void(0)" data-id="'.
                                            $userSurvey->id.'" data-original-title="delete"
                                            data-url="'.route('admin.surveys.reports.delete', $userSurvey).'" class="ms-3 edit btn btn-danger btn-sm
                                            deleteUserSurvey"><i class="fa-solid fa-trash-can"></i></a>';

                return $btn;
            })
            ->make(true);

        return $allUserSurveys;
    }

    public function destroy(UserSurvey $userSurvey) 
    {
        if ($userSurvey->surveyAnswers()->detach()) {
            return $userSurvey->delete();
        }

        throw new Exception(config('parameters.exception_message'));
    }
}