<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPeople extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'post_peoples';
    protected $fillable = [
        'post_id',
        'people_id'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
