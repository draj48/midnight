<?php

namespace App\Livewire;

use Livewire\Component;

class WatchComponent extends Component
{
    public $cover;
    public $listing;
    public $videos = [];
    public $isPreloader = true;

    public function mount($listing)
    {
        if ($listing->type == 'movie') {
            $this->cover = $listing->coverurl;
        } elseif (isset($listing->post->type) AND $listing->post->type == 'tv') {
            $this->cover = $listing->post->coverurl;
        } else {
            $this->cover = $listing->coverurl;
        }
        foreach ($listing->videos as $video) {
            $this->videos[] = [
                'label' => $video->label ?? 'Stream',
                'type' => $video->type,
                'link' => route('embed', $video->id),
            ];
        }
        if ($listing->type == 'movie') {
            if (config('settings.vidsrc') and $listing->tmdb_id) {
//                $this->videos[] = [
//                    'label' => 'Flicky',
//                    'type' => 'embed',
//                    'link' => 'https://flicky.host/embed/movie/?id=' . $listing->tmdb_id . '&server=Multi',
//                ];




                $this->videos[] = [
                    'label' => 'Prime',
                    'type' => 'embed',
                    'link' => 'https://player.videasy.net/movie/' . $listing->tmdb_id,
                ];





//                $this->videos[] = [
//                    'label' => 'Dual',
//                    'type' => 'embed',
//                    'link' => 'https://www.vidsrc.wtf/api/2/movie/?id=' . $listing->tmdb_id,
//                ];





                $this->videos[] = [
                    'label' => '4K Ultra',
                    'type' => 'embed',
                    'link' => 'https://player4u.xyz/embed?key=' . $listing->title,
                ];





                $this->videos[] = [
                    'label' => 'Asli 4K',
                    'type' => 'embed',
                    'link' => 'https://xprime.tv/watch/' . $listing->tmdb_id,
                ];





                $this->videos[] = [
                    'label' => 'FastPlay',
                    'type' => 'embed',
                    'link' => 'https://111movies.com/movie/' . $listing->tmdb_id,
                ];




//                $this->videos[] = [
//                    'label' => 'autoembed',
//                    'type' => 'embed',
//                    'link' => 'https://player.autoembed.cc/embed/movie/' . $listing->tmdb_id . '?server=5',
//                ];





//                $this->videos[] = [
//                    'label' => 'Favy',
//                    'type' => 'embed',
//                    'link' => 'https://netplayz.ru/watch?type=movie&id=' . $listing->tmdb_id,
//                ];





                $this->videos[] = [
                    'label' => 'VidScr',
                    'type' => 'embed',
                    'link' => 'https://vidsrc.to/embed/movie/' . $listing->tmdb_id,
                ];




                $this->videos[] = [
                    'label' => 'embed',
                    'type' => 'embed',
                    'link' => 'https://embed.su/embed/movie/' . $listing->tmdb_id,
                ];





                $this->videos[] = [
                    'label' => 'moviesclub',
                    'type' => 'embed',
                    'link' => 'https://moviesapi.club/movie/' . $listing->tmdb_id,
                ];





//                    'label' => 'AniSAGA',
//                    'type' => 'embed',
//                    'link' => 'https://plyrxcdn.site/v/' . $listing->tmdb_id . '/',
//                ];




                

                













// SHOW api






            }
        } elseif (isset($listing->post->type) AND $listing->post->type == 'tv') {
            if (config('settings.vidsrc') and $listing->post->tmdb_id) {
//                $this->videos[] = [
//                    'label' => 'Flicky',
//                    'type' => 'embed',
//                    'link' => 'https://flicky.host/embed/tv/?id=' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number . '&server=Multi',
//                ];



                $this->videos[] = [
                    'label' => 'Prime',
                    'type' => 'embed',
                    'link' => 'https://player.videasy.net/tv/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number,
                ];





                $this->videos[] = [
                    'label' => 'Dual',
                    'type' => 'embed',
                    'link' => 'https://www.vidsrc.wtf/api/2/tv/?id=' . $listing->post->tmdb_id . '&s=' . $listing->season_number . '&e=' . $listing->episode_number,
                ];





                $this->videos[] = [
                    'label' => '4K Ultra',
                    'type' => 'embed',
                    'link' => 'https://player4u.xyz/embed?key=' . $listing->post->title . ' S' . sprintf('%02d', $listing->season_number) . 'E' . sprintf('%02d', $listing->episode_number),
                ];




                $this->videos[] = [
                    'label' => 'Asli 4K',
                    'type' => 'embed',
                    'link' => 'https://xprime.tv/watch/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number,
                ];






                $this->videos[] = [
                    'label' => 'FastPlay',
                    'type' => 'embed',
                    'link' => 'https://111movies.com/tv/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number,
                ];





//                $this->videos[] = [
//                    'label' => 'autoembed',
//                    'type' => 'embed',
//                    'link' => 'https://player.autoembed.cc/embed/tv/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number . '?server=5',
//                ];





                $this->videos[] = [
                    'label' => 'VidScr',
                    'type' => 'embed',
                    'link' => 'https://vidsrc.to/embed/tv/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number,
                ];



                $this->videos[] = [
                    'label' => 'embed',
                    'type' => 'embed',
                    'link' => 'https://embed.su/embed/tv/' . $listing->post->tmdb_id . '/' . $listing->season_number . '/' . $listing->episode_number,
                ];
                
                
                
                
                
                
                
                
//                $this->videos[] = [
//                    'label' => 'AniSAGA',
//                    'type' => 'embed',
//                    'link' => 'https://plyrxcdn.site/v/' . $listing->post->tmdb_id . 's' . $listing->season_number . 'ep' . $listing->episode_number . '/',
//                ];





































            }
        }
    }

    public function watching()
    {
        $this->isPreloader = false;
    }

    public function render()
    {
        return view('livewire.watch');
    }
}
