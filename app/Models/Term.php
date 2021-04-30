<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'start_date',
        'end_classes_date',
        'end_date',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function groups(): Relation
    {
        return $this->hasMany(Group::class);
    }
}
