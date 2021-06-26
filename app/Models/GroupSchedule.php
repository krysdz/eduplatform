<?php

namespace App\Models;

use App\Enums\DayOfWeekType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperGroupSchedule
 */
class GroupSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'day_of_week_type',
        'interval_days',
        'first_date',
        'last_date',
        'start_time',
        'end_time',
        'teacher_id',
        'room_name',
    ];

    protected $casts = [
        'day_of_week_type' => DayOfWeekType::class,
    ];

    public function __toString()
    {
        return parent::__toString();
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }

    public function teacher(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
