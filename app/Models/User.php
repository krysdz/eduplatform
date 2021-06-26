<?php

namespace App\Models;

use App\Enums\UserRoleType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',

        'first_name',
        'last_name',
        'code',
        'degree',

        'phone',
        'website',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (User $user) {
            $user->roles()->delete();
        });
    }

    public function __toString()
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function roles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function groupsMember(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function groupSchedules(): HasMany
    {
        return $this->hasMany(GroupSchedule::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members');
    }

    public static function getTeachers(): Collection
    {
        return User::whereHas('roles', function($q) {
            $q->where('type', '=', UserRoleType::Teacher);
        })->get();
    }

    public static function getStudents(): Collection
    {
        return User::whereHas('roles', function($q) {
            $q->where('type', '=', UserRoleType::Student);
        })->get();
    }
}
