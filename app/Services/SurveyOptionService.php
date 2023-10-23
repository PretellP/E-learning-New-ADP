<?php

namespace App\Services;

use App\Models\{SurveyStatement, SurveyOption};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SurveyOptionService
{
    public function storeAll(Request $request, SurveyStatement $statement)
    {
        foreach ($request['option'] as $option) {
            $this->store($option, $statement);
        }

        return true;
    }

    public function update($description, SurveyOption $option)
    {
        return $option->update([
            "description" => $description
        ]);
    }

    public function store($description, SurveyStatement $statement)
    {
        return $statement->options()->create([
            "description" => $description
        ]);
    }

    public function destroyAll(SurveyStatement $statement)
    {
        return $statement->options()->delete();
    }

    public function destroy(SurveyOption $option)
    {
        return $option->delete();
    }
}