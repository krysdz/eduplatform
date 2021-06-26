<?php

use App\Models\Group;
use App\Models\ScheduledLesson;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
//            $table->foreignIdFor(Group::class)->constrained();
//            $table->foreignIdFor(User::class, 'start_by')->constrained('users');
            $table->foreignIdFor(ScheduledLesson::class)->constrained();

//            $table->unsignedTinyInteger('state_type');
//            $table->datetime('proposed_at');
//            $table->unsignedSmallInteger('duration_minutes');

            $table->unsignedTinyInteger('number');
            $table->string('name')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
