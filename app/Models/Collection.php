<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory,Sluggable;

    public $timestamps = false;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'slug'],
            ],
        ];
    }
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'collection_posts', 'collection_id', 'post_id');
    }

    public function postsLimited()
    {
        return $this->belongsToMany(Post::class, 'collection_posts', 'collection_id', 'post_id')->limit(4);
    }
}
