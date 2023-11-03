<?php

namespace App\Services;

use App\Models\{Survey, SurveyGroup};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SurveyGroupService
{
    public function getDataTable(Survey $survey)
    {
        $allGroups = DataTables::of($survey->surveyGroups()->withCount('statements'))
            ->editColumn('name', function ($group) {
                return '<a href="'. route('admin.surveys.all.groups.show', $group) .'">'. $group->name .'</a>';
            })
            ->addColumn('action', function ($group) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $group->id . '" data-url="'. route('admin.surveys.all.groups.update', $group) .'"
                                data-send="'. route('admin.surveys.all.groups.edit', $group) .'"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editGroup"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $group->statements_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $group->id . '" data-original-title="delete" data-type="index"
                                    data-url="'. route('admin.surveys.all.groups.desrtoy', $group) .'" class="ms-3 edit btn btn-danger btn-sm
                                    deleteGroup"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['name', 'action'])
            ->make(true);

        return $allGroups;
    }

    public function store(Request $request, Survey $survey)
    {
        return $survey->surveyGroups()->create($request->validated());
    }

    public function update(Request $request, SurveyGroup $group)
    {
        return $group->update($request->validated());
    }

    public function destroy(SurveyGroup $group)
    {
        return $group->delete();
    }
}