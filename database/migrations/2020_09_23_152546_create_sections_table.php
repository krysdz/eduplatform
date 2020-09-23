<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->smallInteger('position')->nullable();
            $table->foreignId('lesson_id')->nullable();
            $table->foreignId('group_id');
            $table->text('description')->nullable();
            $table->boolean('is_active');

            $table->foreign('lesson_id')->on('lessons')->references('id');
            $table->foreign('group_id')->on('groups')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
