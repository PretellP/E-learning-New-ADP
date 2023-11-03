<?php

namespace App\Http\Controllers\Reports;

use App\Exports\SurveyProfileExport;
use App\Http\Controllers\Controller;
use App\Services\Reports\ProfileSurveyService;
use App\Services\SurveyService;
use Illuminate\Http\Request;

class ProfileSurveyReportController extends Controller
{
    private $profileSurveyService;

    public function __construct(ProfileSurveyService $service) {
        $this->profileSurveyService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->profileSurveyService->getDataTable($request);
        }

        return view('admin.surveys.reports.profile.index');
    }

    public function downloadExcelProfile(Request $request, SurveyService $surveyService)
    {
        $surveyProfileExport = new SurveyProfileExport;
        
        $surveyProfileExport->setUserSurveys($surveyService->getByFilters($request, 'user_profile'));

        $date_info = $request->filled('from_date') &&
                    $request->filled('end_date') ? 
                    $request->from_date.'_'.$request->end_date :
                    'todos_los_registros';

        return $surveyProfileExport->download(
            'reporte-perfil-usuario_'. $date_info .'.xlsx'
        );
    }
}
