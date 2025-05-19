<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PostJob;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Post;
use App\Models\PostPeople;
use App\Models\PostSubtitle;
use App\Models\Tag;
use App\Models\PostVideo;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Traits\PostTrait;
use App\Traits\PeopleTrait;
use OneSignal;

class MovieController extends Controller
{
    use PeopleTrait, PostTrait;

    public function index(Request $request)
    {
        $config = [
            'title' => __('Movies'),
            'nav' => 'movie',
            'filter' => true,
            'route' => 'movie',
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
        $listings = Post::where('type','movie')->when($search, function ($query) use ($search) {
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
            'title' => __('Movie'),
            'route' => 'movie',
            'nav' => 'movie',
        ];

        $tabs = [
            'overview' => __('Overview'),
            'video' => __('Video'),
            'people' => __('People'),
            'subtitle' => __('Subtitle'),
            'advanced' => __('Advanced')
        ];
        $genres = Genre::get();
        $countries = Country::where('subtitle','active')->get();
        return view('admin.post.form', compact('config', 'tabs', 'genres', 'countries'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);


        $model = new Post();

        $folderDate = date('m-Y');

        if ($request->hasFile('image') || $request->filled('image_url')) {
            $imagename = Str::random(10);
            $imageFile = $request->image ?? $request->input('image_url');
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename,'webp');
            $model->image = $uploaded_image;
        }

        if ($request->hasFile('cover') || $request->filled('cover_url')) {
            $imagename = Str::random(10);
            $coverFile = $request->image ?? $request->input('cover_url');
            $uploaded_cover = fileUpload($coverFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename);
            fileUpload($coverFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename,'webp');
            $model->cover = $uploaded_cover;
        }

        if ($request->hasFile('slide') || $request->filled('slide_url')) {
            $imagename = Str::random(10);
            $slideFile = $request->slide ?? $request->input('slide_url');
            $uploaded_slide = fileUpload($slideFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-'.$imagename);
            fileUpload($slideFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-'.$imagename,'webp');
            $model->slide = $uploaded_slide;
        }
        if ($request->hasFile('story') || $request->filled('story_url')) {
            $imagename = Str::random(10);
            $storyFile = $request->story ?? $request->input('story_url');
            $uploaded_story = fileUpload($storyFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-'.$imagename);
            fileUpload($storyFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-'.$imagename,'webp');
            $model->story = $uploaded_story;
        }

        $model->type = 'movie';
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
        $model->arguments       = $request->arguments;
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->featured = $request->input('featured', 'disable');
        $model->slider = $request->input('slider', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();

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

        // Video
        if ($request->has('video')) {
            foreach ($request->input('video') as $key) {
                if ($key['link']) {
                    $video = new PostVideo();
                    $video->label = $key['label'];
                    $video->type = $key['type'];
                    $video->link = $key['link'];
                    $model->videos()->save($video);
                }
            }
        }

        // Subtitle
        if ($request->has('subtitle')) {
            foreach ($request->input('subtitle') as $key) {
                if (!empty($key['link'])) {
                    $file = $key['link'];
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path(config('attr.poster.subtitle_path').$folderDate.'/'), $fileName);
                    $subtitle = new PostSubtitle();
                    $subtitle->country_id = $key['country_id'];
                    $subtitle->link = $fileName;
                    $model->subtitles()->save($subtitle);
                }
            }
        }

        // People
        if ($request->has('people')) {
            foreach ($request->input('people') as $key) {
                $traitPeople = $this->PeopleTmdb($key);
                if (!empty($traitPeople->id)) {
                    $model->peoples()->attach($traitPeople->id);
                }
            }
        }


        return redirect()->route('admin.movie.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Movie'),
            'route' => 'movie',
            'nav' => 'movie',
        ];


        $listing = Post::where('id', $id)->firstOrFail() ?? abort(404);

        $tabs = [
            'overview' => __('Overview'),
            'video' => __('Video'),
            'people' => __('People'),
            'subtitle' => __('Subtitle'),
            'advanced' => __('Advanced')
        ];

        $genres = Genre::get();
        $countries = Country::where('subtitle','active')->get();

        $fetch = array();

        $fetch['data'] = $this->postFetch($listing);
        foreach ($listing->peoples as $people) {
            $fetch['peoples'][] = $this->peoplesFetch($people);
        }
        foreach ($listing->videos as $video) {
            $fetch['videos'][] = $this->videosFetch($video);
        }
        foreach ($listing->downloads as $download) {
            $fetch['videos'][] = $this->videosFetch($download);
        }
        foreach ($listing->subtitles as $subtitle) {
            $fetch['subtitles'][] = $this->subtitlesFetch($subtitle);
        }

        return view('admin.post.form', compact('config', 'listing', 'tabs', 'genres', 'countries', 'fetch'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);

        $model = Post::findOrFail($id);

        $folderDate = $model->created_at->translatedFormat('m-Y');

        if ($request->hasFile('image') || $request->filled('image_url')) {
            $imagename = Str::random(10);
            $imageFile = $request->image ?? $request->input('image_url');
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.size_x'), config('attr.poster.size_y'), $imagename,'webp');
            $model->image = $uploaded_image;
        }

        if ($request->hasFile('cover') || $request->filled('cover_url')) {
            $imagename = Str::random(10);
            $coverFile = $request->cover ?? $request->input('cover_url');
            $uploaded_cover = fileUpload($coverFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename);
            fileUpload($coverFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.cover_size_x'), config('attr.poster.cover_size_y'), 'cover-'.$imagename,'webp');
            $model->cover = $uploaded_cover;
        }

        if ($request->hasFile('slide') || $request->filled('slide_url')) {
            $imagename = Str::random(10);
            $slideFile = $request->slide ?? $request->input('slide_url');
            $uploaded_slide = fileUpload($slideFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-'.$imagename);
            fileUpload($slideFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.slide_x'), config('attr.poster.slide_y'), 'slide-'.$imagename,'webp');
            $model->slide = $uploaded_slide;
        }
        if ($request->hasFile('story') || $request->filled('story_url')) {
            $imagename = Str::random(10);
            $storyFile = $request->story ?? $request->input('story_url');
            $uploaded_story = fileUpload($storyFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-'.$imagename);
            fileUpload($storyFile, config('attr.poster.path').$folderDate.'/', config('attr.poster.story_x'), config('attr.poster.story_y'), 'story-'.$imagename,'webp');
            $model->story = $uploaded_story;
        }

        $model->type = 'movie';
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
        $model->arguments       = $request->arguments;
        $model->featured = $request->input('featured', 'disable');
        $model->slider = $request->input('slider', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->update();

        PostJob::dispatch($model,$request->send_notification)->afterResponse();

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

        // Video
        if ($request->has('video')) {
            foreach ($request->input('video') as $key) {
                if ($key['id'] and $key['link']) {
                    $getVideo = PostVideo::findOrFail($key['id']);
                    $getVideo->label = $key['label'];
                    $getVideo->type = $key['type'];
                    $getVideo->link = $key['link'];
                    $getVideo->save();
                } elseif ($key['link']) {
                    $model->videos()->create(array('type' => $key['type'], 'link' => $key['link'],'label' => $key['label']));
                }
            }
        }

        // Subtitle
        if ($request->has('subtitle')) {
            foreach ($request->subtitle as $key) {
                if ($key['id'] and !empty($key['link'])) {

                    $file = $key['link'];
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path(config('attr.poster.subtitle_path').$folderDate.'/'), $fileName);

                    $getSubtitle = PostSubtitle::findOrFail($key['id']);
                    $getSubtitle->country_id = $key['country_id'];
                    $getSubtitle->link = $fileName;
                    $getSubtitle->save();
                } elseif (!empty($key['link'])) {

                    $file = $key['link'];
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path(config('attr.poster.subtitle_path').$folderDate.'/'), $fileName);

                    $model->subtitles()->create(array('country_id' => $key['country_id'], 'link' => $fileName));
                }
            }
        }
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

        Cache::flush();
        return redirect()->route('admin.movie.edit', $model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->comments()->delete();
        $post->tags()->delete();
        $post->videos()->delete();
        $post->subtitles()->delete();
        $post->peoples()->delete();
        $post->watchlist()->delete();
        $post->report()->delete();
        $post->logs()->delete();
        $post->reactions()->delete();
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
}
