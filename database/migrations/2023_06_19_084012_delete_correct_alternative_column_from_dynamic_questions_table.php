<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCorrectAlternativeColumnFromDynamicQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamic_questions', function (Blueprint $table) {  // REVISAR - oruede que no funcione con 
            $table->dropColumn('correct_alternative_id');                 // los quizz antiguos
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dynamic_questions', function (Blueprint $table) {
            $table->bigInteger('correct_alternative_id')->unsigned()->after('points');
        });
    }
}
