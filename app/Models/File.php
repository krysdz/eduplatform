<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'filename',
        'extension',
        'mimetype',
        'path',
        'size',
        'title',
        'fileable_id',
        'fileable_type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return $this->filename;
    }

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function fileable(): Relation
    {
        return $this->morphTo();
    }
}
