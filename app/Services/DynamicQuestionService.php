<?php

namespace App\Services;

use App\Models\{DynamicQuestion, Exam};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class DynamicQuestionService
{
    public function getDataTable(int $exam_id = null)
    {
        $query = DynamicQuestion::with(['questionType:id,description'])
            ->withCount(['evaluations']);

        if ($exam_id) {
            $query->where('exam_id', $exam_id);
        }

        $allQuestions = DataTables::of($query)
            ->editColumn('statement', function ($question) {
                return '<a href="' . route('admin.exams.questions.show', $question) . '">' . $question->statement . '</a>';
            })
            ->editColumn('created_at', function ($question) {
                return $question->created_at;
            })
            ->editColumn('updated_at', function ($question) {
                return $question->updated_at;
            })
            ->editColumn('active', function ($question) {
                $status = $question->active;
                $statusBtn = '<span class="status ' . getStatusClass($status) . '">' . getStatusText($status) . '</span>';

                return $statusBtn;
            })
            ->addColumn('action', function ($question) {
                if ($question->evaluations_count == 0) {
                    $btn = '<a href="javascript:void(0)" data-id="' .
                        $question->id . '" data-original-title="delete"
                                        data-url="' . route('admin.exams.questions.destroy', $question) . '" class="ms-3 edit btn btn-danger btn-sm
                                        deleteQuestion-btn"><i class="fa-solid fa-trash-can"></i></a>';
                } else {
                    $btn = '<a href="javascript:void(0)" data-id="' .
                        $question->id . '" data-original-title="delete" class="ms-3 btn btn-danger disabled btn-sm"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['statement', 'action', 'active'])
            ->make(true);

        return $allQuestions;
    }

    public function getQuestionTypeView($question = null, $questionType_id)
    {
        switch ($questionType_id) {
            case 1:
                return view('admin.exams.partials.questionTypes.unique_answer', compact('question', 'questionType_id'))->render();
            case 2:
                return view('admin.exams.partials.questionTypes.multiple_answer', compact('question', 'questionType_id'))->render();
            case 3:
                return view('admin.exams.partials.questionTypes.true_false', compact('question', 'questionType_id'))->render();
            case 4:
                return view('admin.exams.partials.questionTypes.fill_in_the_blank', compact('question', 'questionType_id'))->render();
            case 5:
                return view('admin.exams.partials.questionTypes.matching', compact('question', 'questionType_id'))->render();
            default:
                return '';
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function store($request, Exam $exam, $storage)
    {
        $data = normalizeInputStatus($request->all());

        $question = $exam->questions()->create($data);

        if ($question) {
            $isStored = app(dynamicAlternativeService::class)->storeAll($request, $question, $storage);

            if ($isStored) {
                return $question;
            }
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function update($request, DynamicQuestion $question, $storage)
    {
        $data = normalizeInputStatus($request->all());

        if ($question->evaluations_count == 0) {
            $isUpdated = $question->update($data);
        } else {
            $isUpdated = $question->update(["active" => $data['active']]);
        }

        if ($isUpdated) {

            if ($question->evaluations_count == 0) {

                foreach ($request['alternative'] as $i => $alternative) {

                    if (
                        isset($request['stored-alternatives']) &&
                        array_key_exists($i, $request['stored-alternatives'])
                    ) {

                        $alternativeModel = $question->alternatives->where('id', $request['stored-alternatives'][$i])->first();

                        app(dynamicAlternativeService::class)->update(
                            $alternativeModel,
                            $question->question_type_id,
                            $request,
                            $i,
                            $storage
                        );
                    } else {
                        app(dynamicAlternativeService::class)->store(
                            $request,
                            $question,
                            $i,
                            $storage
                        );
                    }
                }
            }
            
            return $question;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function destroy(DynamicQuestion $question, $storage)
    {
        $alternativesAreDeleted = app(dynamicAlternativeService::class)->destroyAll($question, $storage);

        if ($alternativesAreDeleted) {

            foreach ($question->files as $file) {
                app(FileService::class)->destroy($file, $storage);
            }

            $isDeleted = $question->delete();

            if ($isDeleted) {
                return true;
            }
        }

        throw new Exception('No es posible completar la solicitud');
    }
}
