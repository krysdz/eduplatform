<?php

namespace App\Models;

use App\Enums\AttendanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'lesson_id',
        'type',
    ];

    protected $casts = [
        'type' => AttendanceType::class,
    ];

    public function __toString()
    {
        return $this->type->description;
    }

    public function lesson(): Relation
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student(): Relation
    {
        return $this->belongsTo(User::class);
    }

}
