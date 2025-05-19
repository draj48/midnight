<?php

namespace Database\Seeders;

use App\Models\Broadcast;
use App\Models\Post;
use App\Models\PostEpisode;
use App\Models\PostSeason;
use App\Models\PostVideo;
use App\Models\Tag;
use App\Traits\PostTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TmdbSeeder extends Seeder
{
    use PostTrait;

    public function run()
    {

        $response = Http::get('http://envato.dev/tmdb.json');
        $result = json_decode($response->getBody(), true);
        $i = 0;
        shuffle($result);
        foreach ($result as $item) {
            $folderDate = date('m-Y').'/';
            if (isset($item['id'])) {
                $postArray = $this->tmdbApiTrait($item['type'], $item['id']);
                $i++;
                $model = new Post();

                $folderDate = date('m-Y').'/';
                if ($postArray['image']) {
                    $imagename = Str::random(16);
                    $imageFile = $postArray['image'];
                    $uploaded_image = fileUpload($imageFile, config('attr.poster.path').$folderDate, config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename);
                    fileUpload($imageFile, config('attr.poster.path').$folderDate, config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename,'webp');

                    $model->image = $uploaded_image;
                }

                if ($postArray['cover']) {
                    $imagename = Str::random(10);
                    $coverFile = $postArray['cover'];
                    $uploaded_image = fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename);
                    fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename,'webp');
                    if($uploaded_image) {
                        $model->cover = $uploaded_image;
                    }
                }

                if ($postArray['slide']) {
                    $imagename = Str::random(10);
                    $coverFile = $postArray['slide'];
                    $uploaded_image = fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.slide_size_x'), config('attr.poster.slide_size_y'), 'slide-'.$imagename);
                    fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.slide_size_x'), config('attr.poster.slide_size_y'), 'slide-'.$imagename,'webp');
                    if($uploaded_image) {
                        $model->slide = $uploaded_image;
                    }
                }

                if ($postArray['story']) {
                    $imagename = Str::random(10);
                    $coverFile = $postArray['story'];
                    $uploaded_image = fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.story_size_x'), config('attr.poster.story_size_y'), 'story-'.$imagename);
                    fileUpload($coverFile, config('attr.poster.path').$folderDate, config('attr.poster.story_size_x'), config('attr.poster.story_size_y'), 'story-'.$imagename,'webp');
                    if($uploaded_image) {
                        $model->story = $uploaded_image;
                    }
                }

                $model->type = $postArray['type'];
                $model->title = $postArray['title'];
                $model->title_sub = $postArray['title_sub'];
                $model->slug = SlugService::createSlug(Post::class, 'slug', $postArray['title']);
                $model->tagline = $postArray['tagline'];
                $model->overview = $postArray['overview'];
                $model->release_date = $postArray['release_date'];
                $model->runtime = $postArray['runtime'];
                $model->vote_average = $postArray['vote_average'];
                $model->country_id = $postArray['country_id'];
                $model->trailer = $postArray['trailer'];
                $model->tmdb_image = $postArray['tmdb_image'];
                $model->imdb_id = $postArray['imdb_id'];
                $model->tmdb_id = $postArray['tmdb_id'];
                $model->status = config('settings.draft_post') == 'active' ? 'draft' : 'publish';
                $model->save();
                $syncGenres = null;
                // Category
                if (isset($postArray['genres'])) {
                    foreach ($postArray['genres'] as $key) {
                        $syncGenres[] = $key['current_id'];
                    }
                    $model->genres()->sync($syncGenres);
                }
                // Tag
                if (isset($postArray['tags'])) {
                    $tagArray = array();
                    foreach ($postArray['tags'] as $tag) {
                        if ($tag) {
                            $tagComponent = Tag::where('type', 'post')->firstorcreate(array('tag' => $tag, 'type' => 'post'));
                            $tagArray[$tagComponent->id] = ['post_id' => $model->id, 'tagged_id' => $tagComponent->id];
                        }
                    }
                    $model->tags()->sync($tagArray);
                }

                // Video
                if (isset($postArray['videos'])) {
                    foreach ($postArray['videos'] as $key) {
                        if ($key['link']) {
                            $video = new PostVideo();
                            $video->type = $key['type'];
                            $video->link = $key['link'];
                            $model->videos()->save($video);
                        }
                    }
                }

                // People
                if (isset($postArray['peoples'])) {
                    foreach ($postArray['peoples'] as $key) {
                        $traitPeople = $this->PeopleTmdb($key);
                        if (!empty($traitPeople->id)) {
                            $model->peoples()->attach($traitPeople->id);
                        }
                    }
                }

                // Season
                if (isset($postArray['seasons'])) {
                    foreach ($postArray['seasons'] as $key) {
                        if ($key['season_number']) {
                            $season = new PostSeason();
                            $season->name = $key['name'];
                            $season->season_number = $key['season_number'];
                            $model->seasons()->save($season);

                            $episodes = json_decode($key['episode'], true);
                            foreach ($episodes as $episodeKey) {
                                $episode = new PostEpisode();
                                if (config('settings.tmdb_image') != 'active') {
                                    if (isset($episodeKey['image'])) {
                                        $imagename = Str::random(10);
                                        $imageFile = $episodeKey['image'];
                                        $uploaded_image = fileUpload($imageFile, config('attr.poster.episode_path') . $folderDate, config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename);
                                        fileUpload($imageFile, config('attr.poster.episode_path') . $folderDate, config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename, 'webp');

                                        $episode->image = $uploaded_image;
                                    }
                                }
                                $episode->post_id = $model->id;
                                $episode->name = $episodeKey['name'];
                                $episode->season_number = $season->season_number;
                                $episode->episode_number = $episodeKey['episode_number'];
                                $episode->overview = $episodeKey['overview'];
                                $episode->tmdb_image = $episodeKey['tmdb_image'];
                                $episode->runtime = isset($episodeKey['runtime']) ? $episodeKey['runtime'] : null;
                                $episode->status = config('settings.draft_post') == 'active' ? 'draft' : 'publish';
                                $season->episodes()->save($episode);
                            }
                        }
                    }
                }
            }
            $i++;
        }
    }
}
