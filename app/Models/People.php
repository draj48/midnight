<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory,Sluggable;
    protected $table = 'peoples';

    protected $casts = [
        'arguments' => 'object',
        'birthday' => 'date',
        'death_date' => 'date'
    ];
    protected $dates = [
        'birthday',
        'death_date'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_peoples', 'people_id', 'post_id')->orderBy('release_date','desc');
    }
    public function getImageUrlAttribute()
    {
        if(config('settings.tmdb_image') == 'active') {
            return 'https://image.tmdb.org/t/p/w300'.$this->tmdb_image;
        } else {
            return $this->image
                ? asset(config('attr.people.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->image)
                : '';
        }
    }

    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('name', 'like', '%'.$value.'%');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
