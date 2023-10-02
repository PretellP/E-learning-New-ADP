<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{DynamicQuestion, Exam, QuestionType};
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

    public function index(Request $request, Exam $exam)
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

    public function show(DynamicQuestion $question)
    {
        $question->loadRelationships();
        $questionType_id = $question->question_type_id;

        return view('admin.exams.questions.show', compact(
            'question',
            'questionType_id'
        ));
    }

    public function getQuestionType(Request $request)
    {
        $html = '';
        $success = true;
        $message = '';

        try {
            $html = $this->dynamicQuestionService->getQuestionTypeView(null, $request['value']);
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
        $html = null;
        $htmlQuestion = null;

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $question = $this->dynamicQuestionService->store($request, $exam, $storage);

            $exam->loadRelationships();
            $html = view('admin.exams.partials.exam-box', compact('exam'))->render();
            $htmlQuestion = $this->dynamicQuestionService->getQuestionTypeView(null, $question->question_type_id);
            $message = config('parameters.stored_message');
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

    public function update(Request $request, DynamicQuestion $question)
    {
        $question->loadRelationships();

        $success = true;
        $html = null;

        $storage = env('FILESYSTEM_DRIVER');

        try{
            $question = $this->dynamicQuestionService->update($request, $question, $storage);
            
            $question->loadRelationships();
            $html = $this->dynamicQuestionService->getQuestionTypeView($question, $question->question_type_id);
            $message = config('parameters.updated_message');
        }   
        catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "statement" => $question->statement
        ]);
    }

    public function destroy(Request $request, DynamicQuestion $question)
    {
        $question->loadRelationships();
        $exam = $question->exam;
        
        $success = true;
        $route = null;
        $html = null;

        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->dynamicQuestionService->destroy($question, $storage);

            $exam->loadRelationships();
            $html = view('admin.exams.partials.exam-box', compact('exam'))->render();
            $message = config('parameters.deleted_message');
        }
        catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($request->has('place')){
            $route = route('admin.exams.showQuestions', $exam);
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "route" => $route,
            "html" => $html
        ]);
    }
}
