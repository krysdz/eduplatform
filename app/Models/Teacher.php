<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree',
        'website'
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
