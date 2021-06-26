<?php

namespace App\Models;

use App\Enums\AnnouncementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

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
