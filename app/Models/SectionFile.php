<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'file_id',
        'name',
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
