<?php

namespace App\Models;

use App\Enums\GroupMemberType;
use App\Enums\GroupType;
use App\Enums\GroupTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function __toString()
    {
        return $this->type->description;
    }

    public function term(): Relation
    {
        return $this->belongsTo(Term::class);
    }

    public function course(): Relation
    {
        return $this->belongsTo(Course::class);
    }

    public function groupMembers(): Relation
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function teachers(): Collection
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps()
            ->whereIn('type', GroupMemberType::Teacher)->get();
    }

    public function students(): Collection
    {
        return $this->belongsToMany(User::class, 'group_members')->withTimestamps()
            ->whereIn('type', GroupMemberType::Student)->get();
    }

    public function groupSchedules(): Relation
    {
        return $this->hasMany(GroupSchedule::class);
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
