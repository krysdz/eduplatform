<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'extension',
        'path',
        'mine_type',
        'size',
        'user_id',
    ];

    public function sectionFiles()
    {
        return $this->hasOne(SectionFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
