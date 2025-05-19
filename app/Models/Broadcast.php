<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Reactable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory,Sluggable,Commentable,Reactable;

    protected $casts = [
        'arguments' => 'object'
    ];
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset(config('attr.poster.path') . $this->image)
            : '';
    }
    public function getCoverUrlAttribute()
    {
        return $this->cover
            ? asset(config('attr.poster.path') . $this->cover)
            : '';
    }
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
    public function report()
    {
        return $this->morphMany(Report::class, 'postable');
    }
    public function videos()
    {
        return $this->morphMany(PostVideo::class, 'Postable');
    }

}
