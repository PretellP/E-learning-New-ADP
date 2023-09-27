<?php

namespace App\Services;

use App\Models\{DynamicQuestion, Exam};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class dynamicQuestionService
{
    public function getDataTable(int $exam_id = null)
    {
        $query = DynamicQuestion::with(['questionType:id,description'])
            ->withCount('alternatives');

        if ($exam_id) {
            $query->where('exam_id', $exam_id);
        }

        $allQuestions = DataTables::of($query)
            ->editColumn('statement', function ($question) {
                return '<a href="">' . $question->statement . '</a>';
            })
            ->editColumn('created_at', function ($question) {
                return $question->created_at;
            })
            ->editColumn('updated_at', function ($question) {
                return $question->updated_at;
            })
            ->addColumn('action', function ($question) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $question->id . '" data-url="" 
                                        data-send=""
                                        data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                        editQuestion-btn"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $question->alternatives_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $question->id . '" data-original-title="delete"
                                            data-url="" class="ms-3 edit btn btn-danger btn-sm
                                            deleteQuestion-btn"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['statement', 'action'])
            ->make(true);

        return $allQuestions;
    }

    public function getQuestionTypeView($questionType_id)
    {
        switch ($questionType_id) {
            case 1:
                return view('admin.exams.partials.questionTypes.unique_answer', compact("questionType_id"))->render();
                break;
            case 2:
                return view('admin.exams.partials.questionTypes.multiple_answer', compact('questionType_id'))->render();
                break;
            case 3:
                return view('admin.exams.partials.questionTypes.true_false', compact('questionType_id'))->render();
                break;
            default:
                return '';
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function store($request, Exam $exam)
    {
        $question = DynamicQuestion::create($request + [
            "exam_id" => $exam->id
        ]);

        if ($question) {
            $isStored = app(dynamicAlternativeService::class)->store($request, $question);

            if($isStored){
                return $question;
            }
        }

        throw new Exception('No es posible completar la solicitud');
    }
}
