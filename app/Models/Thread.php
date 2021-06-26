<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperThread
 */
class Thread extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function threadUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'thread_users')->withTimestamps();
    }
}
