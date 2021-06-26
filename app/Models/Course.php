<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCourse
 */
class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'faculty_id',
        'coordinator_id',
        'code',
        'name',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Course $course) {
            $course->groups()->delete();
        });
    }

    public function __toString()
    {
        return $this->name;
    }

    public function faculty(): Relation
    {
        return $this->belongsTo(Faculty::class);
    }

    public function coordinator(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function groups(): Relation
    {
        return $this->hasMany(Group::class);
    }
}
