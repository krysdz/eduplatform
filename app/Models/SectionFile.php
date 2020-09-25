<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'section_id'
    ];

    public function section()
    {
       return $this->belongsTo(Section::class);
    }

    public function file()
    {
       return $this->belongsTo(File::class);
    }
}
