<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory,Sluggable;


    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset(config('attr.article.path') . 'thumb-'.$this->image)
            : '';
    }

    public function getCoverUrlAttribute()
    {
        return $this->image
            ? asset(config('attr.article.path') . $this->image)
            : '';
    }

    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tagged_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
