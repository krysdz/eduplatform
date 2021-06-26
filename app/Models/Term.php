<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Throwable;

/**
 * @mixin IdeHelperTerm
 */
class Term extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'start_date',
        'end_classes_date',
        'end_date',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function groups(): Relation
    {
        return $this->hasMany(Group::class);
    }

    public function checkIsActive(): bool
    {
        return Carbon::now()->between($this->start_date, $this->end_date);
    }

    public static function getActiveTerm(): ?Term
    {
        try {
            $terms = Term::all();

            foreach ($terms as $term) {
                if (Carbon::now()->between($term->start_date, $term->end_date)) {
                    return $term;
                }
            }

            throw new Exception('Brak aktywnego semestru.');
        } catch (Throwable $e) {
            report($e);

            request()->session()->flash('error', $e);
            return null;
        }

    }
}
