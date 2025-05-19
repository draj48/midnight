<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TvCollection;
use App\Jobs\PostJob;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Post;
use App\Models\PostEpisode;
use App\Models\PostSeason;
use App\Models\PostSubtitle;
use App\Models\PostVideo;
use App\Models\Tag;
use App\Traits\PeopleTrait;
use App\Traits\PostTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TvController extends Controller
{
    use PeopleTrait, PostTrait;

    public function index(Request $request)
    {
        $config = [
            'title' => __('TV Shows'),
            'nav' => 'tv',
            'route' => 'tv',
            'filter' => true,
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $status = $request->input('status');
        $genre_id = $request->input('genre_id');
        $member = $request->input('member');
        $featured = $request->input('featured');
        $slider = $request->input('slider');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Post::where('type','tv')->when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($member, function ($query) use ($member) {
            return $query->where('member', $member);
        })->when($featured, function ($query) use ($featured) {
            return $query->where('featured', $featured);
        })->when($slider, function ($query) use ($slider) {
            return $query->where('slider', $slider);
        })->when($genre_id, function ($query) use ($genre_id) {
            return $query->whereHas('genres', function ($query) use ($genre_id) {
                return $query->where('genres.id', $genre_id);
            });
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort, 'status' => $status, 'genre_id' => $genre_id]);

        return view('admin.post.index', compact('config', 'listings','request'));
    }

    public function create()
    {
        $config = [
            'title' => __('TV Show'),
            'heading' => __('TV Show'),
            'route' => 'tv',
            'nav' => 'tv',
        ];

        $tabs = [
            'overview' => __('Overview'),
            'season' => __('Season'),
            'people' => __('People'),
            'advanced' => __('Advanced')
        ];
        $genres = Genre::get();
        $countries = Country::get();
        return view('admin.post.form', compact('config', 'tabs', 'genres', 'countries'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);


        $model = new Post();

        $folderDate = date('m-Y') . '/';

        if (config('settings.tmdb_image') != 'active') {
            if ($request->hasFile('image') || $request->filled('image_url')) {
                $imagename = Str::random(10);
                $imageFile = $request->image ?? $request->input('image_url');
                $uploaded_image = fileUpload($imageFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename);
                fileUpload($imageFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename, 'webp');
                $model->image = $uploaded_image;
            }

            if ($request->hasFile('cover') || $request->filled('cover_url')) {
                $imagename = Str::random(10);
                $coverFile = $request->image ?? $request->input('cover_url');
                $uploaded_cover = fileUpload($coverFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-' . $imagename);
                fileUpload($coverFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-' . $imagename, 'webp');
                $model->cover = $uploaded_cover;
            }

            if ($request->hasFile('slide') || $request->filled('slide_url')) {
                $imagename = Str::random(10);
                $slideFile = $request->slide ?? $request->input('slide_url');
                $uploaded_slide = fileUpload($slideFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-' . $imagename);
                fileUpload($slideFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-' . $imagename, 'webp');
                $model->slide = $uploaded_slide;
            }
            if ($request->hasFile('story') || $request->filled('story_url')) {
                $imagename = Str::random(10);
                $storyFile = $request->story ?? $request->input('story_url');
                $uploaded_story = fileUpload($storyFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-' . $imagename);
                fileUpload($storyFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-' . $imagename, 'webp');
                $model->story = $uploaded_story;
            }
        }

        $model->type = 'tv';
        $model->title = $request->input('title');
        $model->title_sub = $request->input('title_sub');
        $model->slug = SlugService::createSlug(Post::class, 'slug', $request->input('title'));
        $model->tagline = $request->input('tagline');
        $model->overview = $request->input('overview');
        $model->release_date = $request->input('release_date');
        $model->runtime = $request->input('runtime');
        $model->vote_average = $request->input('vote_average');
        $model->country_id = $request->input('country_id');
        $model->trailer = $request->input('trailer');
        $model->quality = $request->input('quality');
        $model->view = $request->input('view', '0');
        $model->imdb_id = $request->input('imdb_id');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->arguments = $request->arguments;
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->featured = $request->input('featured', 'disable');
        $model->slider = $request->input('slider', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();


        PostJob::dispatch($model, $request->send_notification)->afterResponse();

        // Category
        $model->genres()->sync($request->genre);

        // Tag
        $tagArray = array();
        foreach (explode(',', $request->input('tag')) as $tag) {
            if ($tag) {
                $tagComponent = Tag::where('type', 'post')->firstorcreate(array('tag' => $tag, 'type' => 'post'));
                $tagArray[$tagComponent->id] = ['post_id' => $model->id, 'tagged_id' => $tagComponent->id];
            }
        }
        $model->tags()->sync($tagArray);


        // People
        if ($request->has('people')) {
            foreach ($request->input('people') as $key) {
                $traitPeople = $this->PeopleTmdb($key);
                if (!empty($traitPeople->id)) {
                    $model->peoples()->attach($traitPeople->id);
                }
            }
        }

        // Season
        if ($request->has('season')) {
            foreach ($request->input('season') as $key) {
                if ($key['season_number']) {
                    $season = new PostSeason();
                    $season->name = $key['name'];
                    $season->season_number = $key['season_number'];
                    $season->tmdb_id = isset($key['tmdb_id']) ? $key['tmdb_id'] : null;
                    $model->seasons()->save($season);

                    if (isset($key['episode']) and isset($key['tmdb_id'])) {
                        $episodes = json_decode($key['episode'], true);
                        foreach ($episodes as $episodeKey) {

                            $episode = new PostEpisode();
                            if (config('settings.tmdb_image') != 'active') {
                                if (isset($episodeKey['image'])) {
                                    $imagename = Str::random(10);
                                    $imageFile = $episodeKey['image'];
                                    $uploaded_image = fileUpload($imageFile, config('attr.poster.episode_path'). $folderDate . '/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename);
                                    fileUpload($imageFile, config('attr.poster.episode_path'). $folderDate . '/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename, 'webp');
                                    $episode->image = $uploaded_image;
                                }
                            }
                            $episode->post_id = $model->id;
                            $episode->tmdb_id = $episodeKey['tmdb_id'];
                            $episode->name = $episodeKey['name'];
                            $episode->episode_number = $episodeKey['episode_number'];
                            $episode->season_number = $episodeKey['season_number'];
                            $episode->overview = $episodeKey['overview'];
                            $episode->tmdb_image = $episodeKey['tmdb_image'];
                            $episode->runtime = isset($episodeKey['runtime']) ? $episodeKey['runtime'] : null;
                            $episode->status = 'publish';
                            $season->episodes()->save($episode);
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.tv.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }


    public function edit($id)
    {
        $config = [
            'title' => __('TV Show'),
            'route' => 'tv',
            'nav' => 'tv',
        ];


        $listing = Post::where('id', $id)->firstOrFail() ?? abort(404);

        $tabs = [
            'overview' => __('Overview'),
            'season' => __('Season'),
            'people' => __('People'),
            'advanced' => __('Advanced')
        ];

        $genres = Genre::get();
        $countries = Country::get();

        $fetch = array();

        $fetch['data'] = $this->postFetch($listing);
        foreach ($listing->peoples as $people) {
            $fetch['peoples'][] = $this->peoplesFetch($people);
        }
        foreach ($listing->videos as $video) {
            $fetch['videos'][] = $this->videosFetch($video);
        }
        foreach ($listing->subtitles as $subtitle) {
            $fetch['subtitles'][] = $this->subtitlesFetch($subtitle);
        }
        foreach ($listing->seasons as $season) {
            $fetch['seasons'][] = $this->seasonsFetch($season);
        }

        return view('admin.post.form', compact('config', 'listing', 'tabs', 'genres', 'countries', 'fetch'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);

        $model = Post::findOrFail($id);


        $folderDate = $model->created_at->translatedFormat('m-Y') . '/';
        if (config('settings.tmdb_image') != 'active') {
            if ($request->hasFile('image') || $request->filled('image_url')) {
                $imagename = Str::random(10);
                $imageFile = $request->image ?? $request->input('image_url');
                $uploaded_image = fileUpload($imageFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename);
                fileUpload($imageFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename, 'webp');
                $model->image = $uploaded_image;
            }

            if ($request->hasFile('cover') || $request->filled('cover_url')) {
                $imagename = Str::random(10);
                $coverFile = $request->image ?? $request->input('cover_url');
                $uploaded_cover = fileUpload($coverFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-' . $imagename);
                fileUpload($coverFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-' . $imagename, 'webp');
                $model->cover = $uploaded_cover;
            }

            if ($request->hasFile('slide') || $request->filled('slide_url')) {
                $imagename = Str::random(10);
                $slideFile = $request->slide ?? $request->input('slide_url');
                $uploaded_slide = fileUpload($slideFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-' . $imagename);
                fileUpload($slideFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-' . $imagename, 'webp');
                $model->slide = $uploaded_slide;
            }
            if ($request->hasFile('story') || $request->filled('story_url')) {
                $imagename = Str::random(10);
                $storyFile = $request->story ?? $request->input('story_url');
                $uploaded_story = fileUpload($storyFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-' . $imagename);
                fileUpload($storyFile, config('attr.poster.path') . $folderDate . '/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-' . $imagename, 'webp');
                $model->story = $uploaded_story;
            }
        }

        $model->type = 'tv';
        $model->title = $request->input('title');
        $model->title_sub = $request->input('title_sub');
        if ($model->slug != $request->input('slug')) {
            $model->slug = SlugService::createSlug(Post::class, 'slug', $request->input('slug'));
        }
        $model->tagline = $request->input('tagline');
        $model->overview = $request->input('overview');
        $model->release_date = $request->input('release_date');
        $model->runtime = $request->input('runtime');
        $model->vote_average = $request->input('vote_average');
        $model->country_id = $request->input('country_id');
        $model->trailer = $request->input('trailer');
        $model->quality = $request->input('quality');
        $model->view = $request->input('view', '0');
        $model->imdb_id = $request->input('imdb_id');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->arguments = $request->arguments;
        $model->featured = $request->input('featured', 'disable');
        $model->slider = $request->input('slider', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->update();

        PostJob::dispatch($model, $request->send_notification)->afterResponse();

        // Genre
        $model->genres()->sync($request->genre);

        // Tag
        $tagArray = array();
        foreach (explode(',', $request->input('tag')) as $tag) {
            if ($tag) {
                $tagComponent = Tag::where('type', 'post')->firstorcreate(array('tag' => $tag, 'type' => 'post'));
                $tagArray[$tagComponent->id] = ['post_id' => $model->id, 'tagged_id' => $tagComponent->id];
            }
        }
        $model->tags()->sync($tagArray);

        // People
        if ($request->has('people')) {
            foreach ($request->input('people') as $key) {
                $traitPeople = $this->PeopleTmdb($key);
                if (!empty($traitPeople->id)) {
                    $syncPeople[] = $traitPeople->id;
                }
            }
            $model->peoples()->sync($syncPeople);
        }

        // Season
        if ($request->has('season')) {
            foreach ($request->input('season') as $key) {
                if ($key['season_number']) {

                    $season = PostSeason::where('season_number', $key['season_number'])->where('post_id', $model->id)->first();
                    if (empty($season->id)) {
                        $season = new PostSeason();
                    }
                    $season->name = $key['name'];
                    $season->tmdb_id = isset($key['tmdb_id']) ? $key['tmdb_id'] : null;
                    $season->season_number = $key['season_number'];
                    $model->seasons()->save($season);
                    if (isset($key['episode']) and isset($key['tmdb_id'])) {
                        $episodes = json_decode($key['episode'], true);
                        foreach ($episodes as $episodeKey) {

                            $episode = PostEpisode::where('post_season_id', $season->id)->where('tmdb_id', $episodeKey['tmdb_id'])->where('post_id', $model->id)->first();
                            if (empty($episode->id)) {
                                $episode = new PostEpisode();

                                if (config('settings.tmdb_image') != 'active') {
                                    if (isset($episodeKey['image'])) {
                                        $imagename = Str::random(10);
                                        $imageFile = $episodeKey['image'];
                                        $uploaded_image = fileUpload($imageFile, config('attr.poster.episode_path'). $folderDate . '/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename);
                                        fileUpload($imageFile, config('attr.poster.episode_path'). $folderDate . '/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename, 'webp');

                                        $episode->image = $uploaded_image;
                                    }
                                }
                                $episode->post_id = $model->id;
                                $episode->tmdb_id = $episodeKey['tmdb_id'];
                                $episode->name = $episodeKey['name'];
                                $episode->episode_number = $episodeKey['episode_number'];
                                $episode->season_number = $episodeKey['season_number'];
                                $episode->overview = $episodeKey['overview'];
                                $episode->tmdb_image = $episodeKey['tmdb_image'];
                                $episode->runtime = isset($episodeKey['runtime']) ? $episodeKey['runtime'] : null;
                                $episode->status = 'publish';
                                $season->episodes()->save($episode);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.tv.edit', $model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function search(Request $request)
    {
        // Filter
        $search = $request->q;

        return TvCollection::collection(Post::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->limit(5)->get());
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $episodes = $post->episodes;

        foreach ($episodes as $episode) {
            $episode->reactions()->delete();
            $episode->watchlist()->delete();
            $episode->comments()->delete();
            $episode->logs()->delete();
            $episode->report()->delete();
            $episode->videos()->delete();
            $episode->subtitles()->delete();
            $episode->delete();
        }
        $post->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }

    public function videoDestroy(Request $request)
    {
        PostVideo::find($request->id)->delete();
    }

    public function subtitleDestroy(Request $request)
    {
        PostSubtitle::find($request->id)->delete();
    }

    public function seasonDestroy(Request $request)
    {
        PostSeason::find($request->id)->delete();
    }
}
