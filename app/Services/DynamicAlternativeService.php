<?php

namespace App\Services;

use App\Models\{DynamicAlternative};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class dynamicAlternativeService
{
    public function store($request, $question, $storage)
    {
        $success = false;

        foreach ($request['alternative'] as $i => $alternative) {

            if (
                $question->question_type_id == 1 ||             // TIPO RESPUESTA ÚNICA
                $question->question_type_id == 3                // TIPO VERDADERO O FALSO
            ) {
                $isCorrect = $request['is_correct'] == $i ? 1 : 0;
            } elseif ($question->question_type_id == 2) {       // TIPO RESPUESTA MÚLTIPLE
                $isCorrect = isset($request['is_correct_' . $i]) ? 1 : 0;
            } elseif (
                $question->question_type_id == 4 ||       // TIPO RELLENAR ESPACIO
                $question->question_type_id == 5            // TIPO RELACIONAR
            ) {
                $isCorrect = 1;
            } else {
                return false;
            }

            $alternativeModel = DynamicAlternative::create([
                "description" => $alternative,
                "is_correct" => $isCorrect,
                "dynamic_question_id" => $question->id
            ]);

            if ($alternativeModel) {

                if ($question->question_type_id == 5) {

                    if($request->hasFile('image-'. $i)){
                        $file_type = 'imagenes';
                        $category = 'preguntas_dinamicas';
                        $belongsTo = 'preguntas_dinamicas';
                        $relation = 'one_one';

                        $file = $request->file('image-'. $i);

                        app(FileService::class)->store(
                            $alternativeModel,
                            $file_type,
                            $category,
                            $file,
                            $storage,
                            $belongsTo,
                            $relation
                        );
                    }

                    $success = app(droppableOptionService::class)
                            ->store($request['droppable-option'][$i], $alternativeModel->id);
                }
                else{
                    $success = true;
                }

            } else {
                $success = false;
            }
        }

        return $success;
    }
}
