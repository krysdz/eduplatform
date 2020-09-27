<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_item_id',
        'student_id',
        'grade_value',
        'score',
        'comment',
    ];

    public function gradeItem()
    {
        return $this->belongsTo(GradeItem::class);
    }

    public function student()
    {
       return $this->belongsTo(Student::class);
    }
}
