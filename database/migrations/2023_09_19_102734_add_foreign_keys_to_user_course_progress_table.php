<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserCourseProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_course_progress', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('section_chapter_id')->constrained('section_chapters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_course_progress', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['section_chapter_id']);
        });
    }
}
