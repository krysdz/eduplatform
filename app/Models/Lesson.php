<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperLesson
 */
class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'name',
        'scheduled_lesson_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return parent::__toString();
    }

//    public function group(): Relation
//    {
//        return $this->belongsTo(Group::class);
//    }

    public function section(): Relation
    {
        return $this->hasOne(Section::class);
    }

    public function attendances(): Relation
    {
        return $this->hasMany(Attendance::class);
    }

    public function scheduledLesson(): Relation
    {
        return $this->belongsTo(ScheduledLesson::class);
    }
}
