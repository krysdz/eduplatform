<?php

namespace App\Models;

use App\Enums\GroupMemberType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function __toString()
    {
        return $this->user->type->description;
    }

    public function groups(): Relation
    {
        return $this->belongsToMany(Group::class);
    }

    public function users(): Relation
    {
        return $this->belongsToMany(User::class);
    }

    public function teachers(): Collection
    {
        return $this->belongsToMany(User::class, 'users')->withTimestamps()
            ->whereIn('type', GroupMemberType::Teacher)->get();
    }

    public function students(): Collection
    {
        return $this->belongsToMany(User::class, 'users')->withTimestamps()
            ->whereIn('type', GroupMemberType::Student)->get();
    }
}
