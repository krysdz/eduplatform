<?php

namespace App\Models;

use App\Enums\AttendanceType;
use App\Notifications\AttendanceNotification;
use App\Notifications\GradeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

/**
 * @mixin IdeHelperAttendance
 */
class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'scheduled_lesson_id',
        'type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::created(function ($attendance) {
            Notification::send($attendance->student, new AttendanceNotification((string) $attendance->scheduledLesson->group, $attendance->scheduledLesson->date, $attendance->type->description));
        });

        static::updated(function ($attendance) {
            Notification::send($attendance->student, new AttendanceNotification((string) $attendance->scheduledLesson->group, $attendance->scheduledLesson->date, $attendance->type->description, $attendance->getChanges()));
        });
    }

    protected $casts = [
        'type' => AttendanceType::class,
    ];

    public function __toString()
    {
        return $this->type->description;
    }

    public function scheduledLesson(): Relation
    {
        return $this->belongsTo(ScheduledLesson::class);
    }

    public function student(): Relation
    {
        return $this->belongsTo(User::class);
    }

}
