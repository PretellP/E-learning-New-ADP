<?php

namespace App\Services;

use App\Models\{DynamicAlternative};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class dynamicAlternativeService
{

    public function store($request, $question)
    {
        if ($question->question_type_id == 1) {

            foreach ($request['alternative'] as $i => $alternative) {

                $isCorrect = $request['is_correct'] == $i ? 1 : 0;

                DynamicAlternative::create([
                    "description" => $alternative,
                    "is_correct" => $isCorrect,
                    "dynamic_question_id" => $question->id
                ]);
            }

            return true;
        }

        throw new Exception('No es posible completar la solicitud');
    }

}