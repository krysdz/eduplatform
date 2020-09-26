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
        'is_active'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function section()
    {
        return $this->hasOne(Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
