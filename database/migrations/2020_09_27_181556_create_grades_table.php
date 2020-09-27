<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('grade_item_id');
            $table->foreignId('student_id');
            $table->string('grade_value')->nullable();
            $table->string('score')->nullable();
            $table->string('comment')->nullable();

            $table->foreign('grade_item_id')->on('grade_items')->references('id');
            $table->foreign('student_id')->on('students')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
