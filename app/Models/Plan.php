<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'taxes' => 'object',
        'coupons' => 'object'
    ];

    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('name', 'like', '%'.$value.'%');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
