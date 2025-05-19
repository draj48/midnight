<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'reactable_id', 'reactable_type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactable()
    {
        return $this->morphTo();
    }
    public function post()
    {
        return $this->morphMany(Post::class, 'reactable');
    }
    public function episode()
    {
        return $this->morphMany(PostEpisode::class, 'reactable');
    }
    public function comment()
    {
        return $this->morphMany(Comment::class, 'reactable');
    }
}
