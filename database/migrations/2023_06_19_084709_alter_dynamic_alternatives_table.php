<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDynamicAlternativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamic_alternatives', function (Blueprint $table) {
            $table->boolean('is_correct')->after('description')->nullable();
            $table->string('url_img', 500)->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dynamic_alternatives', function (Blueprint $table) {
            $table->dropColumn('is_correct');
            $table->dropColumn('url_img');
        });
    }
}
