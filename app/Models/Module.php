<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory,Sluggable;
    public $timestamps = false;

    protected $casts = [
        'arguments' => 'object'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'slug'],
            ],
        ];
    }
}
