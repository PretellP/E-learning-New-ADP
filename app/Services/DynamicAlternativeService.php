<?php

namespace App\Services;

use App\Models\{DynamicAlternative};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class dynamicAlternativeService
{

    public function store($request, $question)
    {
        $success = false;

        foreach ($request['alternative'] as $i => $alternative) {

            if (
                $question->question_type_id == 1 ||             // TIPO RESPUESTA ÚNICA
                $question->question_type_id == 3                // TIPO VERDADERO O FALSO
            )
            {
                $isCorrect = $request['is_correct'] == $i ? 1 : 0;
            } elseif ($question->question_type_id == 2) {       // TIPO RESPUESTA MÚLTIPLE
                $isCorrect = isset($request['is_correct_' . $i]) ? 1 : 0;
            } else {
                return false;
            }

            $alternative = DynamicAlternative::create([
                "description" => $alternative,
                "is_correct" => $isCorrect,
                "dynamic_question_id" => $question->id
            ]);

            if ($alternative) {
                $success = true;
            } else {
                $success = false;
            }
        }

        return $success;

        throw new Exception('No es posible completar la solicitud');
    }
}
