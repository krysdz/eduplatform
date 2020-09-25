<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('file_id');
            $table->foreignId('section_id');

            $table->foreign('file_id')->on('files')->references('id')->onDelete('cascade');
            $table->foreign('section_id')->on('sections')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_files');
    }
}
