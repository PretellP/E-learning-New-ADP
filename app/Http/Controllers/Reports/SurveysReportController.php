<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UserSurveyExport;
use App\Http\Controllers\Controller;
use App\Models\UserSurvey;
use App\Services\Reports\UserSurveyService;
use App\Services\SurveyService;
use Exception;
use Illuminate\Http\Request;

class SurveysReportController extends Controller
{
    private $userSurveyService;

    public function __construct(UserSurveyService $service)
    {
        $this->userSurveyService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userSurveyService->getDataTable($request);
        }

        return view('admin.surveys.reports.index');
    }

    public function downloadExcelUserSurveys(Request $request, SurveyService $surveyService)
    {
        $surveyProfileExport = new UserSurveyExport;
        
        $surveyProfileExport->setUserSurveys($surveyService->getByFilters($request, null));

        $date_info = $request->filled('from_date') &&
                    $request->filled('end_date') ? 
                    $request->from_date.'_'.$request->end_date :
                    'últimos-500';

        return $surveyProfileExport->download(
            'reporte-encuestas-usuarios_'. $date_info .'.xlsx'
        );
    }

    public function destroy(UserSurvey $userSurvey)
    {
        try {
            $success = $this->userSurveyService->destroy($userSurvey);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = config('parameters.exception_message');
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }
}
