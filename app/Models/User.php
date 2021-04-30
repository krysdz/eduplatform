<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function roles(): Relation
    {
        return $this->hasMany(UserRole::class);
    }

    public function files(): Relation
    {
        return $this->hasMany(File::class);
    }

    public function groups(): Relation
    {
        return $this->belongsToMany(Group::class);
    }

    public function attendances(): Relation
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): Relation
    {
        return $this->hasMany(Grade::class);
    }
}
