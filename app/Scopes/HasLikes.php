<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Relations\morphMany;
use App\Models\Reaction;
use App\Models\User;

trait HasLikes
{
    public function likes(): morphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
    public function dislikes(): morphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
    public function isLiked(): bool|int
    {
        if (auth()->user()) {
            return $this->morphMany(Reaction::class, 'reactable')->where('user_id', auth()->user()->id)->count();
        }

        return false;
    }
    public function removeLike(): bool
    {
        if (auth()->user()) {
            return $this->morphMany(Reaction::class, 'reactable')->where('user_id', auth()->user()->id)->delete();
        }

        return false;
    }
}
