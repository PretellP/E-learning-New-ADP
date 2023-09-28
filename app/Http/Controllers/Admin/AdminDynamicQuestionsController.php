<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Exam, QuestionType};
use App\Services\dynamicQuestionService;
use Exception;
use Illuminate\Http\Request;

class AdminDynamicQuestionsController extends Controller
{
    private $dynamicQuestionService;

    public function __construct(dynamicQuestionService $service)
    {
        $this->dynamicQuestionService = $service;
    }

    public function show(Request $request, Exam $exam)
    {
        if ($request->ajax()) {
            return $this->dynamicQuestionService->getDataTable($exam->id);
        }

        $exam->loadRelationships();
        $questionTypes = QuestionType::get(['id', 'description']);

        return view('admin.exams.questions.index', compact(
            'exam',
            'questionTypes'
        ));
    }

    public function getQuestionType(Request $request)
    {
        $html = '';
        $success = true;
        $message = '';

        try {

            $html = $this->dynamicQuestionService->getQuestionTypeView($request['value']);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "messsage" => $message,
            "html" => $html,
        ]);
    }

    public function store(Request $request, Exam $exam)
    {
        $success = true;
        $message = '';
        $html = '';
        $htmlQuestion = '';

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $question = $this->dynamicQuestionService->store($request, $exam, $storage);

            $exam->loadRelationships();
            $html = view('admin.exams.partials.exam-box', compact('exam'))->render();
            $htmlQuestion = $this->dynamicQuestionService->getQuestionTypeView($question->question_type_id);

        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "data_show" => [
                "html" => $html,
                "htmlQuestion" => $htmlQuestion
            ]
        ]);
    }
}
