<?php

namespace App\Services;

use App\Models\{Survey, UserSurvey};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SurveyService
{
    public function getDataTable()
    {
        $allSurveys = DataTables::of(Survey::withCount(
                [
                    'surveyGroups',
                ]
            ))
            ->editColumn('name', function ($survey) {
                return '<a href="'. route('admin.surveys.all.show', $survey) .'">'. $survey->name .'</a>';
            })
            ->editColumn('destined_to', function ($survey) {
                return config('parameters.survey_destined_to')[$survey->destined_to] ?? '-';
            })
            ->editColumn('active', function ($survey) {
                $status = $survey->active == 'S' ? 'active' : 'inactive';
                $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                $statusBtn = '<span class="status ' . $status . '">' . $txtBtn . '</span>';

                return $statusBtn;
            })
            ->addColumn('action', function ($survey) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $survey->id . '" data-url="'. route('admin.surveys.all.update', $survey) .'"
                                data-send="'. route('admin.surveys.all.edit', $survey) .'"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editSurvey"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $survey->survey_groups_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $survey->id . '" data-original-title="delete" data-type="index"
                                    data-url="'. route('admin.surveys.all.destroy', $survey) .'" class="ms-3 edit btn btn-danger btn-sm
                                    deleteSurvey"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['name', 'active', 'action'])
            ->make(true);

        return $allSurveys;
    }

    public function store(Request $request, $storage)
    {
        $data = normalizeInputStatus($request->validated());

        $survey = Survey::create($data);

        if ($survey) {

            if ($request->hasFile('image')){

                $file_type = 'imagenes';
                $category = 'encuestas';
                $belongsTo = 'encuestas';
                $relation = 'one_one';

                $file = $request->file('image');

                app(FileService::class)->store(
                    $survey,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return $survey;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update(Request $request, Survey $survey, $storage)
    {
        $data = normalizeInputStatus($request->validated());

        if ($survey->update($data)) {
            if ($request->hasFile('image')) {

                app(FileService::class)->destroy($survey->file, $storage);

                $file_type = 'imagenes';
                $category = 'encuestas';
                $file = $request->file('image');
                $belongsTo = 'encuestas';
                $relation = 'one_one';

                app(FileService::class)->store(
                    $survey,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }
            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }   

    public function destroy(Survey $survey, $storage) 
    {
        if ($survey->file) {
            app(FileService::class)->destroy($survey->file, $storage);
        }

        return $survey->delete();
    }

    public function getByFilters(Request $request, $destined_to = NULL)
    {
        $surveysQuery = UserSurvey::with([
                                        'user', 
                                        'survey', 
                                        'surveyAnswers', 
                                        'company',
                                        'event.user',
                                        'event.course',
                                    ])
                                    ->withCount('surveyAnswers')
                                    ->where('status', 'finished')
                                    ->orderBy('id', 'desc');

        if ($destined_to) {
            $surveysQuery->whereHas('survey', function ($q) use ($destined_to){
                $q->where('destined_to', $destined_to);
            });
        }

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $surveysQuery->whereBetween('end_time', [$request->from_date, $request->end_date]);
        }

        return $surveysQuery->limit(500)->get();
    }
}