<?php

namespace App\Models;

use App\Observers\PostObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Commentable;
use App\Traits\Reactable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{

    use HasFactory,Sluggable,Commentable,Reactable;

    protected $casts = [
        'release_date' => 'date:Y-m-d',
        'arguments' => 'object'
    ];
    public static function boot()
    {
        parent::boot();

    }

    public function getImageUrlAttribute()
    {
        if(config('settings.tmdb_image') == 'active') {
            if($this->tmdb_image AND empty($this->image)) {
                return 'https://image.tmdb.org/t/p/w300'.$this->tmdb_image;
            } else {
                return $this->image
                    ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->image)
                    : '';
            }
        } else {
            return $this->image
                ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->image)
                : '';
        }
    }
    public function getCoverUrlAttribute()
    {
        if(config('settings.tmdb_image') == 'active') {

            if($this->tmdb_image AND empty($this->cover)) {
                return 'https://image.tmdb.org/t/p/w1280_and_h720_bestv2'.$this->tmdb_image;
            } else {
                return $this->cover
                    ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->cover)
                    : '';
            }
        } else {
            return $this->cover
                ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->cover)
                : '';
        }
    }
    public function getSlideUrlAttribute()
    {
        if(config('settings.tmdb_image') == 'active') {

            if($this->tmdb_image AND empty($this->slide)) {
                return 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces'.$this->tmdb_image;
            } else {
                return $this->slide
                    ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->slide)
                    : '';
            }
        } else {
            return $this->slide
                ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->slide)
                : '';
        }
    }
    public function getStoryUrlAttribute()
    {
        if(config('settings.tmdb_image') == 'active') {
            if($this->tmdb_image AND empty($this->story)) {
                return 'https://image.tmdb.org/t/p/w235_and_h235_face'.$this->tmdb_image;
            } else {
                return $this->story
                    ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->story)
                    : '';
            }
        } else {
            return $this->story
                ? asset(config('attr.poster.path') . $this->created_at->translatedFormat('m-Y').'/'.$this->story)
                : '';
        }
    }
    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tagged_id');
    }

    public function seasons()
    {
        return $this->hasMany(PostSeason::class);
    }
    public function episodes()
    {
        return $this->hasMany(PostEpisode::class)->where('status','publish');
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'post_genres', 'post_id', 'genre_id');
    }
    public function videos()
    {
        return $this->morphMany(PostVideo::class, 'Postable')->whereNot('type','download');
    }
    public function downloads()
    {
        return $this->morphMany(PostVideo::class, 'Postable')->where('type','download');
    }
    public function subtitles()
    {
        return $this->morphMany(PostSubtitle::class, 'Postable');
    }
    public function peoples()
    {
        return $this->belongsToMany(People::class, 'post_peoples', 'post_id', 'people_id');
    }
    public function country()
    {
        // If the current plan is default, or the plan is not active
        return $this->belongsTo('App\Models\Country');
    }
    public function watchlist()
    {
        return $this->morphToMany(User::class, 'postable','watchlists');
    }
    public function report()
    {
        return $this->morphMany(Report::class, 'postable');
    }
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'postable');
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
