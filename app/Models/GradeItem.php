<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperGradeItem
 */
class GradeItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'code',
        'name',
        'color',
        'weight',
        'maxscore',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }

    public function grades(): Relation
    {
        return $this->hasMany(Grade::class);
    }
}
