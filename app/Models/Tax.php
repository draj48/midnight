<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tax extends Model
{
    protected $casts = [
        'regions' => 'object'
    ];

    public function scopeOfRegion(Builder $query, $value)
    {
        $query->whereNull('regions')
            ->when($value, function ($query) use ($value) {
                $query->orWhere('regions', 'like', '%' . $value . '%');
            });

        return $query;
    }
}
