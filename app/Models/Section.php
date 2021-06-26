<?php

namespace App\Models;

use App\Enums\LessonStateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'state_type',
        'name',
        'description',
        'published_at'
    ];

    protected $casts = [
        'state_type' => LessonStateType::class,
    ];

    public function __toString()
    {
        return parent::__toString();
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }

    public function lesson(): Relation
    {
        return $this->belongsTo(Lesson::class);
    }

    public function sectionFiles(): Relation
    {
        return $this->hasMany(SectionFile::class);
    }
}
