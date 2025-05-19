<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @see \JsonResource */
class TvCollection extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $seasons = array();
        foreach ($this->seasons() as $season) {
            $seasons[] = [
                'id' => $season->id,
                'name' => $season->name
            ];
        }
        return [
            'id' => $this->id,
            'image' => $this->imageurl,
            'title' => $this->title,
            'seasons' => $this->seasons,
        ];
    }
}
