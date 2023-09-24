<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishings', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->integer('publishing_order')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('content', 1000)->nullable();
            $table->string('url_img', 500)->nullable();  // ELIMINAR
            $table->timestamp('publication_time');
            $table->boolean('status');
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
        Schema::dropIfExists('publishings');
    }
}
