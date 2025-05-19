<?php

namespace App\Observers;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use OneSignal;

class PostObserver
{
    public $afterCommit = true;
    /**
     * Handle the User "created" event.
     */
    public function created(Post $post): void
    {

        Cache::flush(); // Tüm önbelleği temizler
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Post $post): void
    {
        Cache::flush();

    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Post $post): void
    {

        Cache::flush();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Post $post): void
    {
        Cache::flush(); // Tüm önbelleği temizler
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        Cache::flush();
    }
}
