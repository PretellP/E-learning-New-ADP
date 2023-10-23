<?php

namespace App\Services;

use App\Models\{Survey, SurveyGroup, SurveyOption, SurveyStatement};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SurveyStatementService
{

    public function getDataTable(SurveyGroup $group)
    {
        $allStatements = DataTables::of($group->statements()->withCount('options'))
        ->editColumn('description', function ($statement) {
            return '<a href="'. route('admin.surveys.groups.statements.show', $statement) .'">'. $statement->description .'</a>';
        })
        ->editColumn('type', function ($statement) {
            return config('parameters.statement_type')[$statement->type] ?? '-';
        })
        ->editColumn('created_at', function ($statement) {
            return $statement->created_at;
        })
        ->editColumn('updated_at', function ($statement) {
            return $statement->updated_at;
        })
        ->addColumn('action', function ($statement) {
            
            $btn = '<a href="javascript:void(0)" data-id="' .
                $statement->id . '" data-original-title="delete" data-type="index"
                            data-url="'. route('admin.surveys.groups.statement.destroy', $statement) .'" class="ms-3 edit btn btn-danger btn-sm
                            deleteStatement"><i class="fa-solid fa-trash-can"></i></a>';

            return $btn;
        })
        ->rawColumns(['description', 'action'])
        ->make(true);

        return $allStatements;
    }   

    public function getStatementType($statement = NULL, SurveyGroup $group, $value)
    {
        $surveyType = $group->survey->destined_to;

        if ($value == 'select_multi') {

            if ($surveyType == 'course_live') {
                $html = view('admin.surveys.partials.boxes._course_live', compact('statement'))->render();
            } else {
                $html = view('admin.surveys.partials.boxes._select_multi', compact('statement'))->render();
            }

        } else {
            $html = '';
        }

        return $html;
    }

    public function store(Request $request, SurveyGroup $group)
    {
        $statement = $group->statements()->create($request->all());

        if ($statement) {

            if ($request->has('option')) {
                app(SurveyOptionService::class)->storeAll($request, $statement);
            }

            return $statement;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update(Request $request, SurveyStatement $statement)
    {
        if ($statement->update($request->all())) {

            if ($request->has('option')) {
                foreach ($request['option'] as $i => $description) {
                    if (
                        isset($request['stored-options']) && 
                        array_key_exists($i, $request['stored-options'])
                    ) {
                        $optionModel = $statement->options->where('id', $request['stored-options'][$i])->first();

                        app(SurveyOptionService::class)->update($description, $optionModel);
                    }
                    else {
                        app(SurveyOptionService::class)->store($description, $statement);
                    }
                }
            }

            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function destroy(SurveyStatement $statement)
    {
        if ($statement->options->count() > 0) {
            app(SurveyOptionService::class)->destroyAll($statement);
        }

        return $statement->delete();
    }
}