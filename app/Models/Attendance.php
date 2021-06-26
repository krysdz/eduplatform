<?php

namespace App\Models;

use App\Enums\AttendanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

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
