<?php

namespace App\Models;

use App\Enums\AnnouncementType;
use App\Notifications\AnnouncementNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

/**
 * @mixin IdeHelperAnnouncement
 */
class Announcement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'title',
        'type',
        'description',
        'mark_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

        'mark_at',
    ];

    protected static function booted()
    {
        static::created(function ($announcement) {
            Notification::send($announcement->group->students(), new AnnouncementNotification((string) $announcement->group, $announcement->title));
        });
    }

    protected $casts = [
        'type' => AnnouncementType::class,
    ];

    public function __toString()
    {
        return $this->title;
    }

    public function group(): Relation
    {
        return $this->belongsTo(Group::class);
    }


}
