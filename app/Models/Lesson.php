<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'title',
        'date',
        'group_id',
        'description',
        'is_active'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
