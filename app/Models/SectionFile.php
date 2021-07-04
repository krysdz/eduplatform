<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSectionFile
 */
class SectionFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'file_id',
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return parent::__toString();
    }

    public function section(): Relation
    {
        return $this->belongsTo(Section::class);
    }

    public function file(): Relation
    {
        return $this->belongsTo(File::class);
    }
}
