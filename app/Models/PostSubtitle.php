<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubtitle extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'post_subtitles';
    protected $fillable = [
        'country_id',
        'link'
    ];

    public function postable()
    {
        return $this->morphTo();
    }

    public function getLinkUrlAttribute()
    {

        return $this->link
            ? asset(config('attr.poster.subtitle_path') . $this->postable->created_at->translatedFormat('m-Y').'/'.$this->link)
            : '';
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
