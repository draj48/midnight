<?php

namespace App\Observers;

use App\Models\PostEpisode;
use Illuminate\Support\Facades\Cache;

class PostEpisodeObserver
{
    public $afterCommit = true;
    /**
     * Handle the User "created" event.
     */
    public function created(PostEpisode $post): void
    {

        Cache::flush(); // Tüm önbelleği temizler
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(PostEpisode $post): void
    {
        Cache::flush();

    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(PostEpisode $post): void
    {
        Cache::flush();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(PostEpisode $post): void
    {
        Cache::flush(); // Tüm önbelleği temizler
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(PostEpisode $post): void
    {
        Cache::flush();
    }
}
