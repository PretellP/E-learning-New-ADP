<?php

namespace App\Services;

use App\Models\{DynamicAlternative, DynamicQuestion};
use Exception;
use Yajra\DataTables\Facades\DataTables;

class dynamicAlternativeService
{
    public function storeAll($request, $question, $storage)
    {
        $success = false;

        foreach ($request['alternative'] as $i => $alternative) {

            $success = $this->store($request, $question, $i, $storage);
        }

        return $success;
    }

    public function store($request, $question, $index, $storage)
    {
        $success = false;

        $isCorrect = $this->getIsCorrectValue($request, $index, $question->question_type_id);

        $alternativeModel = DynamicAlternative::create([
            "description" => $request['alternative'][$index],
            "is_correct" => $isCorrect,
            "dynamic_question_id" => $question->id
        ]);

        if ($alternativeModel) {

            if ($question->question_type_id == 5) {

                if ($request->hasFile('image-' . $index)) {
                    $file_type = 'imagenes';
                    $category = 'preguntas_dinamicas';
                    $belongsTo = 'preguntas_dinamicas';
                    $relation = 'one_one';

                    $file = $request->file('image-' . $index);

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
                    ->store($request['droppable-option'][$index], $alternativeModel->id);
            } else {
                $success = true;
            }
        } else {
            $success = false;
        }

        return $success;
    }

    private function getIsCorrectValue($request, $index, $question_type_id)
    {
        $isCorrect = false;

        if (
            $question_type_id == 1 ||             // TIPO RESPUESTA ÚNICA
            $question_type_id == 3                // TIPO VERDADERO O FALSO
        ) {
            $isCorrect = $request['is_correct'] == $index ? 1 : 0;
        } elseif ($question_type_id == 2) {       // TIPO RESPUESTA MÚLTIPLE
            $isCorrect = isset($request['is_correct_' . $index]) ? 1 : 0;
        } elseif (
            $question_type_id == 4 ||       // TIPO RELLENAR ESPACIO
            $question_type_id == 5            // TIPO RELACIONAR
        ) {
            $isCorrect = 1;
        } else {
            return false;
        }

        return $isCorrect;
    }

    public function update(DynamicAlternative $alternative, $question_type_id, $request, $index, $storage)
    {
        $success = false;

        $isCorrect = $this->getIsCorrectValue($request, $index, $question_type_id);

        $isUpdated = $alternative->update([
            "description" => $request['alternative'][$index],
            "is_correct" => $isCorrect
        ]);

        if ($isUpdated) {

            if (
                $request->has('image-' . $index) &&
                $request->hasFile('image-' . $index)
            ) {
                app(FileService::class)->destroy($alternative->file, $storage);

                $file_type = 'imagenes';
                $category = 'preguntas_dinamicas';
                $file = $request->file('image-' . $index);
                $belongsTo = 'preguntas_dinamicas';
                $relation = 'one_one';

                app(FileService::class)->store(
                    $alternative,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            if ($request->has('droppable-option')) {

                app(droppableOptionService::class)->update(
                    $alternative->droppableOption,
                    $request['droppable-option'][$index]
                );
            }

            $success = true;
        }

        return $success;
    }

    public function destroyAll(DynamicQuestion $question, $storage)
    {
        $success = false;

        foreach ($question->alternatives as $alternative) {
            $success = $this->destroy($alternative, $storage);
        }

        return $success;
    }

    public function destroy(DynamicAlternative $alternative, $storage)
    {
        if ($alternative->droppableOption != null) {
            app(droppableOptionService::class)->destroy($alternative->droppableOption);
        }

        if ($alternative->file != null) {
            $this->destroyFile($alternative->file, $storage);
        }

        $success = $alternative->delete();

        if (!$success) {
            return false;
        }

        return $success;
    }

    public function destroyFile($file, $storage)
    {
        return app(FileService::class)->destroy($file, $storage);
    }
}
