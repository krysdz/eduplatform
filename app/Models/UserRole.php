<?php

namespace App\Models;

use App\Enums\UserRoleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperUserRole
 */
class UserRole extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
    ];

    protected $casts = [
        'type' => UserRoleType::class,
    ];

    public function __toString()
    {
        return parent::__toString();
    }

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
