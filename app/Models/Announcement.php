<?php

namespace App\Models;

use App\Enums\AnnouncementTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'deadline',
        'title',
        'description',
        'type',
        'group_id'
    ];

    protected $casts = [
        'type' => AnnouncementTypeEnum::class,
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
