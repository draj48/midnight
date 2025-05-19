<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory,Sluggable;

    public $timestamps = false;
    protected $fillable = [
        'tag',
        'type'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tagged_id', 'post_id');
    }
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('tag', 'like', '%'.$value.'%');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['tag', 'slug'],
            ],
        ];
    }
}
