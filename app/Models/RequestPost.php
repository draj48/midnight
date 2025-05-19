<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPost extends Model
{
    protected $fillable = [
        'type',
        'tmdb_id',
        'title',
        'image',
        'request',
    ];
}
