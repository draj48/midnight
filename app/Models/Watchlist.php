<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postable()
    {
        return $this->morphTo();
    }
    public function post()
    {
        return $this->morphMany(Post::class, 'postable');
    }
    public function episode()
    {
        return $this->morphMany(Post::class, 'postable');
    }
}
