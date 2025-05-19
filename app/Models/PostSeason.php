<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSeason extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'post_seasons';
    protected $fillable = [
        'name',
        'season_number'
    ];
    public function episodes()
    {
        return $this->hasMany(PostEpisode::class)->where('status','publish');
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
