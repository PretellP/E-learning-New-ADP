<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyRequest;
use App\Models\{Survey};
use App\Services\{SurveyService};
use Exception;
use Illuminate\Http\Request;

class AdminSurveyController extends Controller
{
    private $surveyService;

    public function __construct(SurveyService $service)
    {
        $this->surveyService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->surveyService->getDataTable();
        }

        return view('admin.surveys.all.index');
    }

    public function show(Survey $survey)
    {
        $survey->loadRelationships();

        return view('admin.surveys.all.show', compact(
            'survey'
        ));
    }

    public function store(SurveyRequest $request)
    {
        $storage = env('FILESYSTEM_DRIVER');
        $show = false;
        $route = NULL;

        try {
            $survey = $this->surveyService->store($request, $storage);
            $success = true;
            $message = config('parameters.stored_message');
        }  catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request['verifybtn'] == 'show') {
            $route = route('admin.surveys.all.show', $survey);
            $show = true;
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "show" => $show,
            "route" => $route,
        ]);
    }

    public function edit(Survey $survey)
    {
        $survey->loadImage();

        $url_img = verifyImage($survey->file);
        $destined_to = config('parameters.survey_destined_to')[$survey->destined_to];

        return response()->json([
            "survey" => $survey,
            "url_img" => $url_img,
            "destined_to" => $destined_to,
        ]);
    }

    public function update(SurveyRequest $request, Survey $survey) 
    {
        $survey->loadImage();

        $storage = env('FILESYSTEM_DRIVER');
        $html = NULL;
        $location = 'index';

        try {
            $success = $this->surveyService->update($request, $survey, $storage);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request->has('place') && $request['place'] == "show") {
            $survey->loadRelationships();
            $html = view('admin.surveys.partials.boxes._survey', compact('survey'))->render();
            $location = "show";
        }
        
        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "title" => $survey->name,
            "location" => $location
        ]);
    }

    public function destroy(Request $request, Survey $survey)
    {
        $storage = env('FILESYSTEM_DRIVER');
        $location = $request['type'];

        $survey->loadImage();

        try {
            $success = $this->surveyService->destroy($survey, $storage);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $route = $location == 'show' ? route('admin.surveys.all.index') : NULL ;  

        return response()->json([
            "success" => $success,
            "message" => $message,
            "location" => $location,
            "route" => $route,
        ]);
    }
}
