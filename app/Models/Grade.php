<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'grade_item_id',
        'student_id',
        'grade',
        'score',
        'comment',
    ];

    public function __toString()
    {
        return parent::__toString();
    }

    public function gradeItem(): Relation
    {
        return $this->belongsTo(GradeItem::class);
    }

    public function student(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
