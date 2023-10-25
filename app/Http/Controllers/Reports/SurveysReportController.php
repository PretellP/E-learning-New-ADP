<?php

namespace App\Http\Controllers\Reports;

use App\Exports\UserSurveyExport;
use App\Http\Controllers\Controller;
use App\Services\Reports\UserSurveyService;
use App\Services\SurveyService;
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

        return view('admin.surveys.userSurveys.index');
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
}
