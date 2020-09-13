<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Admin extends Model
{
    use HasFactory;

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
