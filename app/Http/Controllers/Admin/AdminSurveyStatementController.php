<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{SurveyGroup, SurveyStatement};
use App\Services\SurveyStatementService;
use Exception;
use Illuminate\Http\Request;

class AdminSurveyStatementController extends Controller
{
    private $statementService;

    public function __construct(SurveyStatementService $service)
    {
        $this->statementService = $service;
    }

    public function index(SurveyGroup $group)
    {
        return $this->statementService->getDataTable($group);
    }

    public function show(SurveyStatement $statement)
    {
        $statement->loadRelationships();

        return view('admin.surveys.all.groups.statements.show', compact(
            'statement'
        ));
    }

    public function getStatementType(Request $request, SurveyGroup $group) 
    {
        $html = $this->statementService->getStatementType(null, $group, $request['value']);

        return response()->json([
            "html" => $html
        ]);
    }

    public function store(Request $request, SurveyGroup $group)
    {
        try {
            $statement = $this->statementService->store($request, $group);
            $success = true;
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        $html = $success ? $this->statementService->getStatementType(null, $group, $request['type']) 
                        : NULL;  

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html
        ]);
    }

    public function update(Request $request, SurveyStatement $statement)
    {
        $statement->loadRelationships();
        $html = NULL;

        try {
            $success = $this->statementService->update($request, $statement);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }   

        if ($success) {
            $statement->loadRelationships();
            $html = $this->statementService->getStatementType(
                                            $statement,
                                            $statement->group, 
                                            $statement->type);
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "statement" => $statement
        ]); 
    }

    public function destroy(SurveyStatement $statement)
    {
        $statement->loadRelationships();

        try {
            $success = $this->statementService->destroy($statement);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }
}
