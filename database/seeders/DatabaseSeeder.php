<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    QuestionType
};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $dataQuestionTypes = [
        //     ['id' => '1', 'description' => 'RESPUESTA ÚNICA'],
        //     ['id' => '2', 'description' => 'RESPUESTA MÚLTIPLE'],
        //     ['id' => '3', 'description' => 'VERDADERO O FALSO'],
        //     ['id' => '4', 'description' => 'RELLENAR ESPACIO EN BLANCO'],
        //     ['id' => '5', 'description' => 'RELACIONAR'],
        // ];

        // foreach($dataQuestionTypes as $questionType)
        // {
        //     QuestionType::create($questionType);
        // }

        // DB::table('courses')->update([
        //     "course_type" => "REGULAR"
        // ]);

        // DB::table('dynamic_alternatives')->update([
        //     "is_correct" => 0
        // ]);

        // DB::table('dynamic_questions')->update([
        //     "question_type_id" => 1
        // ]);

        // DB::table('evaluations')
        //     ->where('is_correct', 1)
        //     ->update([
        //         "points" => 2
        //     ]);
    }
}
