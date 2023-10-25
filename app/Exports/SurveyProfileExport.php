<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SurveyProfileExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $userSurveys;
    private $maxColumns;

    public function view() : View
    {
        return view('admin.surveys.exports.table_user_profile', 
            [
                'userSurveys' => $this->userSurveys,
                'maxColumns' => $this->maxColumns,
            ]);
    }

    public function setUserSurveys($userSurveys)
    {
        $this->userSurveys = $userSurveys;
        $this->maxColumns = $userSurveys->max('survey_answers_count');
    }
}
