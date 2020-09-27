<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('mark_weight')->nullable();
            $table->unsignedInteger('max_score')->nullable();
            $table->foreignId('group_id');

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
        Schema::dropIfExists('grade_items');
    }
}
