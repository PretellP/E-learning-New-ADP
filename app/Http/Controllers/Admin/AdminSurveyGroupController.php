<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyGroupRequest;
use App\Models\Survey;
use App\Models\SurveyGroup;
use App\Services\SurveyGroupService;
use Exception;
use Illuminate\Http\Request;

class AdminSurveyGroupController extends Controller
{
    private $groupService;

    public function __construct(SurveyGroupService $service)
    {
        $this->groupService = $service;
    }

    public function index(Request $request, Survey $survey)
    {
        return $this->groupService->getDataTable($survey);
    }

    public function show(SurveyGroup $group)
    {
        $group->loadRelationships();

        return view('admin.surveys.groups.index', compact(
            'group'
        ));
    }

    public function store(SurveyGroupRequest $request, Survey $survey)
    {
        $show = false;
        $route = NULL;
        $html = NULL;

        try {
            $group = $this->groupService->store($request, $survey);
            $success = true;
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request['verifybtn'] == 'show') {
            $route = route('admin.surveys.groups.show', $group);
            $show = true;
        }

        if ($success) {
            $survey->loadRelationships();
            $html = view('admin.surveys.partials.boxes._survey', compact('survey'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "show" => $show,
            "route" => $route,
            "html" => $html
        ]);
    }

    public function edit(SurveyGroup $group)
    {
        return response()->json([
            "group" => $group
        ]);
    }

    public function update(SurveyGroupRequest $request, SurveyGroup $group)
    {
        $html = NULL;
        $location = 'index';

        try {
            $success = $this->groupService->update($request, $group);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request->has('place') && $request['place'] == "show") {
            $group->loadRelationships();
            $html = view('admin.surveys.partials.boxes._group', compact('group'))->render();
            $location = "show";
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "title" => $group->name,
            "location" => $location
        ]);
    }

    public function destroy(Request $request, SurveyGroup $group)
    {
        $location = $request['type'];
        $survey = $group->survey;
        $html = NULL;

        try {
            $success = $this->groupService->destroy($group);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $route = $location == 'show' ? route('admin.surveys.show', $survey) : NULL;  

        if ($success && $location == 'index') {
            $survey->loadRelationships();
            $html = view('admin.surveys.partials.boxes._survey', compact('survey'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "location" => $location,
            "route" => $route,
            "html" => $html
        ]);
    }
}
