<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Reaction;

trait Reactable
{
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
    public function reaction()
    {
        return $this->morphTo();
    }
    public function getReaction($user): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable')->where('user_id', $user->id);
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable')->where('reaction','like');
    }

    public function isReactionBy($user): bool
    {
        return $this->reaction()->where('user_id', $user->id)->exists();
    }

    public function dislikes(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable')->where('reaction','dislike');
    }
}
