<?php

namespace App\Models;

use App\Notifications\GradeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

/**
 * @mixin IdeHelperGrade
 */
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

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::created(function ($grade) {
            Notification::send($grade->student, new GradeNotification((string) $grade->gradeItem->group, $grade->gradeItem->name, $grade->grade, $grade->score));
        });

        static::updated(function ($grade) {
            Notification::send($grade->student,
                new GradeNotification((string) $grade->gradeItem->group, $grade->gradeItem->name, $grade->grade, $grade->score, $grade->getChanges()));
        });
    }

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
