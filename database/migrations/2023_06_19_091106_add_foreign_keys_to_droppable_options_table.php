<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDroppableOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('droppable_options', function (Blueprint $table) {
            $table->foreignId('dynamic_alternative_id')->constrained('dynamic_alternatives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('droppable_options', function (Blueprint $table) {
            $table->dropForeign(['dynamic_alternative_id']);
        });
    }
}
