<?php

namespace App\Models;

use App\Enums\DaysOfWeekEnum;
use App\Enums\GroupTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'teacher_id',
        'term_id',
        'course_id',
        'day_of_classes'
    ];

    protected $casts = [
        'type' => GroupTypeEnum::class,
        'day_of_classes' => DaysOfWeekEnum::class,
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
