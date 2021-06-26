<?php

namespace App\Models;

use App\Enums\GroupMemberType;
use App\Enums\GroupType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'term_id',
        'course_id',
        'type',
        'number',
    ];

    protected $casts = [
        'type' => GroupType::class,
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Group $group) {
            $group->groupMembers()->updateExistingPivot(
                $group->groupMembers()->allRelatedIds(),
                ['deleted_at' => Carbon::now()]
            );
        });
    }

    public function __toString()
    {
        return $this->course.' - gr. nr '.$this->number.' ('.$this->type->description.')';
    }

    public function term(): Relation
    {
        return $this->belongsTo(Term::class);
    }

    public function course(): Relation
    {
        return $this->belongsTo(Course::class);
    }

    public function groupMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps();
    }

    public function teachers(): Collection
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps()
            ->where('type', '=', GroupMemberType::Teacher)->get();
    }

    public function students(): Collection
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps()
            ->where('type', '=',GroupMemberType::Student)->get();
    }

    public function groupSchedules(): Relation
    {
        return $this->hasMany(GroupSchedule::class);
    }

    public function scheduledLessons(): Relation
    {
        return $this->hasMany(ScheduledLesson::class);
    }

    public function lessons(): Relation
    {
        return $this->hasMany(Lesson::class);
    }

    public function sections(): Relation
    {
        return $this->hasMany(Section::class);
    }

    public function announcements(): Relation
    {
        return $this->hasMany(Announcement::class);
    }

    public function gradeItems(): Relation
    {
        return $this->hasMany(GradeItem::class);
    }
}
