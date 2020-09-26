<?php

namespace App\Models;

use App\Enums\AttendanceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'student_id',
        'type',
    ];

    protected $casts = [
        'type' => AttendanceTypeEnum::class,
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
