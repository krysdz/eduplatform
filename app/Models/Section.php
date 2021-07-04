<?php

namespace App\Models;

use App\Notifications\SectionNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

/**
 * @mixin IdeHelperSection
 */
class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'lesson_id',
        'order',
        'name',
        'description',
        'published_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

        'published_at',
    ];

    protected static function booted()
    {
        static::created(function ($section) {
            if ($section->published_at) {
                Notification::send($section->group->students(), new SectionNotification((string) $section->group, $section->name));
            }
        });

        static::updated(function ($section) {
            if ($section->published_at) {
                Notification::send($section->group->students(), new SectionNotification((string) $section->group, $section->name));
            }
        });
    }

    public function __toString()
    {
        return $this->name;
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }

    public function lesson(): Relation
    {
        return $this->belongsTo(Lesson::class);
    }

    public function files(): Relation
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
