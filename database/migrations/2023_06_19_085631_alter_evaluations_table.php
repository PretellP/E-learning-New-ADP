<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->double('points', 8, 2)->after('selected_alternative')->nullable();
            $table->renameColumn('correct_alternative', 'correct_alternatives');
            $table->renameColumn('selected_alternative', 'selected_alternatives');
            // $table->dropColumn('is_correct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->renameColumn('correct_alternatives', 'correct_alternative');
            $table->renameColumn('selected_alternatives', 'selected_alternative');
            // $table->boolean('is_correct')->after('statement');
            $table->dropColumn('points');
        });
    }
}
