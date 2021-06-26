<?php

use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GroupSchedule::class)->constrained();
            $table->foreignIdFor(Group::class)->constrained();
            $table->foreignIdFor(User::class, 'teacher_id')->constrained('users');

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_name');

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
        Schema::dropIfExists('scheduled_lessons');
    }
}
