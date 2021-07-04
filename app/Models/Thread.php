<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperThread
 */
class Thread extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return $this->name ?? Thread::getDynamicThreadName($this);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function threadUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'thread_users')->withTimestamps();
    }

    public static function getOwnThreads()
    {
        return Thread::whereHas('threadUsers', function ($q) {
            $q->where('user_id', '=', Auth::user()->id);
        })->orderByDesc('updated_at')->get();
    }

    public static function getDynamicThreadName(Thread $thread, int $showMaxUsers = 2): string
    {
        $threadUsers = $thread->threadUsers->all();
        $threadName = '';
        $otherUsersCount = 0;

        if(count($threadUsers) === 1) {
            return $threadUsers[0];
        }

        foreach ($threadUsers as $user) {
            if ($user->id === Auth::user()->id) {
                continue;
            }

            $otherUsersCount++;
            $hasMoreToDisplay = $otherUsersCount <= $showMaxUsers;
            $hasOnlyOneLeft = (count($threadUsers) - 1) === ($showMaxUsers + 1);

            if ($hasMoreToDisplay) {
                if ($otherUsersCount !== 1) {
                    $threadName .= ', ';
                }

                $threadName .= $user;
                continue;
            } elseif ($hasOnlyOneLeft) {
                $threadName .= ', ' . $user;
                break;
            }

            $threadName .= ' + ' . (count($threadUsers) - $showMaxUsers - 1) . ' użytkowników';
            break;
        }

        return $threadName;
    }
}
