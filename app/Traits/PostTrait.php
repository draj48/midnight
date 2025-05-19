<?php

namespace App\Traits;

use App\Models\Genre;
use App\Models\Country;
use App\Models\People;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait PostTrait
{
    use PeopleTrait;

    protected function postFilter($request)
    {
        $queryParams = [];
        if ($request->has('category')) {
            $queryParams['category'] = $request->input('category');
        }
        if ($request->has('country')) {
            $queryParams['country'] = $request->input('country');
        }
        if ($request->has('released')) {
            $queryParams['released'] = $request->input('released');
        }
        return $queryParams;
    }

    protected function postFetch($post)
    {
        $this->post = [
            'title' => $post->title,
            'title_sub' => $post->title_sub,
            'tagline' => $post->tagline,
            'overview' => $post->overview,
            'trailer' => $post->trailer,
            'release_date' => isset($post->release_date) ? $post->release_date->format('Y-m-d') : null,
            'runtime' => $post->runtime,
            'vote_average' => $post->vote_average,
            'country_id' => $post->country_id,
            'quality' => $post->quality,
            'tmdb_image' => $post->tmdb_image,
            'imdb_id' => $post->imdb_id,
            'tmdb_id' => $post->tmdb_id
        ];

        return $this->post;
    }

    protected function postjson($post)
    {
        $this->post = [
            'id' => $post->id,
            'type' => $post->type == 'movie' ? __('Movie') : __('TV Show'),
            'title' => $post->title,
            'image' => $post->imageurl
        ];

        return $this->post;
    }

    protected function episodeFetch($episode)
    {
        $this->episode = [
            'tmdb_id' => $episode->tmdb_id,
            'name' => $episode->name,
            'tmdb_image' => $episode->tmdb_image,
            'episode_number' => $episode->episode_number,
            'overview' => $episode->overview,
            'runtime' => $episode->runtime
        ];

        return $this->episode;
    }

    protected function peoplesFetch($people)
    {
        $this->peoples = [
            'id' => $people->id,
            'name' => $people->name,
            'image' => $people->imageurl,
        ];

        return $this->peoples;
    }

    protected function videosFetch($video)
    {
        $this->videos = [
            'id' => $video->id,
            'label' => $video->label,
            'type' => $video->type,
            'link' => $video->link,
        ];

        return $this->videos;
    }

    protected function subtitlesFetch($subtitle)
    {
        $this->subtitles = [
            'id' => $subtitle->id,
            'country_id' => $subtitle->country_id,
            'link' => $subtitle->link,
        ];

        return $this->subtitles;
    }

    protected function seasonsFetch($season)
    {
        $this->seasons = [
            'id' => $season->id,
            'name' => $season->name,
            'season_number' => $season->season_number
        ];

        return $this->seasons;
    }

    protected function tmdbFetchTrait($post, $type = 'movie')
    {
        $this->fetch = [
            'id' => $post['id'],
            'type' => $type,
            'title' => $type == 'movie' ? $post['title'] : $post['name'],
            'title_sub' => $type == 'movie' ? $post['original_title'] : $post['original_name'],
            'overview' => $post['overview'],
            'release_date' => $type == 'movie' ? $post['release_date'] : $post['first_air_date'],
            'vote_average' => number_format($post['vote_average'], 1),
            'image' => $post['poster_path'] ? 'https://image.tmdb.org/t/p/w300'.$post['poster_path'] : null
        ];

        return $this->fetch;
    }

    protected function tmdbApiTrait($type = 'movie', $tmdb_id = null)
    {
        if (isset($tmdb_id)) {

            $response = Http::get('https://api.themoviedb.org/3/'.$type.'/'.$tmdb_id.'?language='.config('settings.tmdb_language').'&append_to_response=videos,keywords,credits&api_key='.config('settings.tmdb_api'));
            $result = json_decode($response->getBody(), true);

            // Video
            if (isset($result['videos']['results'])) {
                foreach ($result['videos']['results'] as $video) {
                    if ($video['type'] == 'Trailer') {
                        $trailer = 'https://www.youtube.com/embed/'.$video['key'];
                    }
                }
            }

            // Keyword
            $tags = array();
            if ((isset($result['keywords']['keywords']) and $type == 'movie') || ($type == 'tv' and isset($result['keywords']['results']))) {
                foreach ($type == 'movie' ? $result['keywords']['keywords'] : $result['keywords']['results'] as $keyword) {
                    if (!empty($keyword['name'])) {
                        $tags[] = trim($keyword['name']);
                    }
                }
            }
            if (isset($result['production_countries'][0]['iso_3166_1'])) {
                $country = Country::where('code', $result['production_countries'][0]['iso_3166_1'])->first();
            }

            $postArray = [
                'type' => $type,
                'tmdb_id' => $tmdb_id,
                'imdb_id' => isset($result['imdb_id']) ? $result['imdb_id'] : null,
                'title' => $type == 'movie' ? $result['title'] : $result['name'],
                'title_sub' => $type == 'movie' ? $result['original_title'] : $result['original_name'],
                'overview' => $result['overview'],
                'image' => isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w500'.$result['poster_path'] : null,
                'cover' => isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w1280'.$result['poster_path'] : null,
                'slide' => isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces'.$result['poster_path'] : null,
                'story' => isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face/'.$result['poster_path'] : null,
                'tmdb_image' => $result['poster_path'],
                'runtime' => $type == 'movie' ? $result['runtime'] : null,
                'release_date' => $type == 'movie' ? $result['release_date'] : $result['first_air_date'],
                'tagline' => $result['tagline'],
                'country_id' => !empty($country) ? $country->id : null,
                'trailer' => isset($trailer) ? $trailer : null,
                'vote_average' => number_format($result['vote_average'], 1),
                'tags' => $tags,
            ];
            foreach ($result['genres'] as $genre) {
                $checkGenre = Genre::where('title', $genre['name'])->first();
                if ($checkGenre) {
                    $postArray['genres'][] = [
                        'id' => $genre['id'],
                        'current_id' => $checkGenre->id,
                        'title' => $checkGenre->title,
                    ];
                }
            }

            // People
            if (config('settings.tmdb_people_limit') > 0) {
                $peopleCount = 1;
                foreach ($result['credits']['cast'] as $cast) {
                    if (isset($cast['profile_path']) and $peopleCount <= config('settings.tmdb_people_limit')) {
                        $postArray['peoples'][] = array(
                            'id' => $cast['id'],
                            'api' => 'active',
                            'name' => $cast['name'],
                            'image' => isset($cast['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$cast['profile_path'] : '',
                        );
                    }
                    $peopleCount++;
                }
            }
            if ($type == 'tv' and config('settings.import_season') == 'active') {

                foreach ($result['seasons'] as $season) {
                    if ($season['season_number'] > 0) {
                        $episodeArray = array();
                        if (config('settings.import_episode') == 'active') {
                            $getEpisodes = Http::get('https://api.themoviedb.org/3/'.$type.'/'.$tmdb_id.'/season/'.$season['season_number'].'?language='.config('settings.tmdb_language').'&api_key='.config('settings.tmdb_api'));
                            $getEpisodes = json_decode($getEpisodes->getBody(), true);
                            foreach ($getEpisodes['episodes'] as $episode) {
                                $episodeArray[] = [
                                    'tmdb_id' => $episode['id'],
                                    'name' => $episode['name'],
                                    'episode_number' => $episode['episode_number'],
                                    'season_number' => $season['season_number'],
                                    'overview' => $episode['overview'],
                                    'runtime' => $episode['runtime'],
                                    'image' => isset($episode['still_path']) ? 'https://image.tmdb.org/t/p/w300'.$episode['still_path'] : null,
                                    'tmdb_image' => isset($episode['still_path']) ? $episode['still_path'] : null
                                ];
                            }
                        }
                        $postArray['seasons'][] = array(
                            'tmdb_id' => $season['id'],
                            'name' => $season['name'],
                            'season_number' => $season['season_number'],
                            'episode' => isset($episodeArray) ? json_encode($episodeArray) : null,
                        );
                    }
                }
            }
            return $postArray;
        }
    }

    protected function tmdbEpisodeApiTrait($request)
    {
        $result = Http::get('https://api.themoviedb.org/3/tv/'.$request->tmdb_id.'/season/'.$request->season_number.'/episode/'.$request->episode_number.'?language='.config('settings.tmdb_language').'&api_key='.config('settings.tmdb_api'));
        $result = json_decode($result->getBody(), true);

        $postArray = [
            'name' => $result['name'],
            'tmdb_id' => $result['id'],
            'episode_number' => $result['episode_number'],
            'season_number' => $request->season_number,
            'overview' => $result['overview'],
            'tmdb_image' => $result['still_path'],
            'image' => 'https://image.tmdb.org/t/p/w500'.$result['still_path'],
            'runtime' => $result['runtime']
        ];
        return $postArray;
    }
}
