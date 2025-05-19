<?php

namespace App\Traits;

use App\Models\People;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait BroadcastTrait
{

    protected function videos($video)
    {
        $this->videos = [
            'id' => $video->id,
            'label' => $video->label,
            'type' => $video->type,
            'link' => $video->link,
        ];

        return $this->videos;
    }
}
