<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_chapters', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('description', 500);
            $table->integer('chapter_order');
            $table->string('url_video', 500); // Eliminar
            $table->integer('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_chapters');
    }
}
