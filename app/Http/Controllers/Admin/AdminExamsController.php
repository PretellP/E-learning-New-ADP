<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Models\{Course, Exam, OwnerCompany};
use App\Services\ExamService;
use Exception;
use Illuminate\Http\Request;

class AdminExamsController extends Controller
{
    private $examService;

    public function __construct(ExamService $service)
    {
        $this->examService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->examService->getDataTable();
        }
        $courses = Course::where('active', 'S')
            ->where('course_type', 'REGULAR')
            ->get(['id', 'description']);
        $ownerCompanies = OwnerCompany::get(['id', 'name']);

        return view('admin.exams.index', compact(
            'courses',
            'ownerCompanies'
        ));
    }

    public function store(ExamRequest $request)
    {
        $success = true;
        $show = false;
        $message = '';
        $route = '';

        try {
            $exam = $this->examService->store($request);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request['verifybtn'] == 'show' && $success) {
            $route = route('admin.exams.showQuestions', $exam);
            $show = true;
        }

        return response()->json([
            "show" => $show,
            "success" => $success,
            "message" => $message,
            "route" => $route
        ]);
    }

    public function edit(Exam $exam)
    {
        $courses = Course::where('active', 'S')
            ->where('course_type', 'REGULAR')
            ->get(['id', 'description']);
        $ownerCompanies = OwnerCompany::get(['id', 'name']);

        return response()->json([
            "exam" => $exam,
            "courses" => $courses,
            "ownerCompanies" => $ownerCompanies
        ]);
    }

    public function update(ExamRequest $request, Exam $exam)
    {
        $success = true;
        $data_show = null;
        $html = null;

        try {
            $this->examService->update($request, $exam);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request['place'] == 'show' && $success) {
            $exam->loadRelationships();
            $html = view('admin.exams.partials.exam-box', compact('exam'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "data_show" => [
                "html" => $html,
                "title" => mb_strtolower($exam->title, 'UTF-8')
            ]
        ]);
    }

    public function destroy(Request $request, Exam $exam)
    {
        $success = true;
        $route = null;

        try {
            $this->examService->destroy($exam);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($request->has('place')){
            $route = route('admin.exams.index');
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "route" => $route
        ]);
    }
}
