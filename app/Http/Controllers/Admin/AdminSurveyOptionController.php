<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{SurveyOption};
use App\Services\SurveyOptionService;
use Exception;
use Illuminate\Http\Request;

class AdminSurveyOptionController extends Controller
{
    private $optionService;

    public function __construct(SurveyOptionService $service)
    {
        $this->optionService = $service;
    }

    public function destroy(SurveyOption $option)
    {
        try {
            $success = $this->optionService->destroy($option);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = config('parameters.exception_message');
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
        ]);
    }
}
