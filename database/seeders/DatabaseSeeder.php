<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    DynamicAlternative,
    QuestionType
};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $dataQuestionTypes = [
            ['id' => '1', 'description' => 'RESPUESTA ÚNICA'],
            ['id' => '2', 'description' => 'RESPUESTA MÚLTIPLE'],
            ['id' => '3', 'description' => 'VERDADERO O FALSO'],
            ['id' => '4', 'description' => 'RELLENAR ESPACIO EN BLANCO'],
            ['id' => '5', 'description' => 'RELACIONAR'],
        ];

        foreach($dataQuestionTypes as $questionType)
        {
            QuestionType::create($questionType);
        }

        DB::table('courses')->update([
            "course_type" => "REGULAR"
        ]);

        
        $allAlternatives = DynamicAlternative::with('question:id,correct_alternative_id')
                                            ->get(['id','dynamic_question_id']);
                                
        foreach ($allAlternatives as $alternative) {
            $is_correct = $alternative->question->correct_alternative_id == $alternative->id ? 
                            1 : 0;
            
            $alternative->update([
                "is_correct" => $is_correct
            ]);
        }

        DB::table('dynamic_questions')->update([
            "question_type_id" => 1
        ]);

        DB::table('evaluations')
            ->where('is_correct', 1)
            ->update([
                "points" => 2
            ]);
    }
}
