<?php

namespace App\Traits;

use App\Models\People;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait PeopleTrait
{
    protected function PeopleTmdb($people)
    {
        if ($people['api'] == 'active') {
            $getPeople = People::where('tmdb_id', $people['id'])->first();
            if (empty($getPeople->id)) {
                $api = Http::get('https://api.themoviedb.org/3/person/' . $people['id'] . '?api_key='.config('settings.tmdb_api').'&language='.config('settings.tmdb_language'));
                $api = json_decode($api->getBody(), true);

                $model = new People;

                $folderDate = date('m-Y') . '/';
                if (config('settings.tmdb_image') != 'active') {
                    $imagename = Str::random(16);
                    $imageFile = 'https://image.tmdb.org/t/p/w300_and_h300_face' . $api['profile_path'];
                    $uploaded_image = fileUpload($imageFile, config('attr.people.path'). $folderDate . '/', config('attr.people.thumb'), config('attr.people.thumb'), $imagename);
                    fileUpload($imageFile, config('attr.people.path'). $folderDate . '/', config('attr.people.thumb'), config('attr.people.thumb'), $imagename,'webp');
                    $model->image = $uploaded_image;
                }

                $model->name = $api['name'];
                $model->slug = SlugService::createSlug(People::class, 'slug', $api['name']);
                $model->bio = $api['biography'];
                $model->birthday = $api['birthday'];
                $model->gender = $api['gender'];
                $model->imdb_id = $api['imdb_id'];
                $model->tmdb_id = $api['id'];
                $model->tmdb_image = $api['profile_path'];
                $model->save();
            } else {
                $model = $getPeople;
            }
        } elseif($people['id']) {
            $model = People::where('id', $people['id'])->first();
        }

        return $model;
    }
}
