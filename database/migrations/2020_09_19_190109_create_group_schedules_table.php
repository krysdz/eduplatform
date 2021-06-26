<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class)->constrained();
            $table->foreignIdFor(User::class, 'teacher_id')->constrained('users');

            $table->unsignedTinyInteger('day_of_week_type');
            $table->unsignedTinyInteger('interval_days');
            $table->date('first_date');
            $table->date('last_date');
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
        Schema::dropIfExists('group_schedules');
    }
}
