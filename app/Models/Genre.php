<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory,Sluggable;

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_genres', 'genre_id', 'post_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class, 'genre_id');
    }
    public function getImage()
    {
        $post = $this->posts()->latest()->first();

        if ($post) {
            return $post->storyurl;
        }

        return null;
    }
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'slug'],
            ],
        ];
    }
}
