<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostVideo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'post_videos';
    protected $fillable = [
        'label',
        'type',
        'link'
    ];
    public function postable()
    {
        return $this->morphTo();
    }
}
