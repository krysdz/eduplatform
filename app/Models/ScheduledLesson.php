<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperScheduledLesson
 */
class ScheduledLesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_schedule_id',
        'group_id',
        'date',
        'start_time',
        'end_time',
        'teacher_id',
        'room_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function teacher(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }

    public function lesson(): Relation
    {
        return $this->hasOne(Lesson::class);
    }
}
