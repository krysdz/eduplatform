<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'end_classes_date',
        'is_active',
        'name',
        'code'
    ];

    public function groups()
    {
       return $this->hasMany(Group::class);
    }
}
