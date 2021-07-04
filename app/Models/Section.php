<?php

namespace App\Models;

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
