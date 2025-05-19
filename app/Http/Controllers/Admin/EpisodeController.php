<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PostEpisodeJob;
use App\Models\Country;
use App\Models\Post;
use App\Models\PostEpisode;
use App\Models\PostSeason;
use App\Models\PostSubtitle;
use App\Models\PostVideo;
use App\Traits\PeopleTrait;
use App\Traits\PostTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EpisodeController extends Controller
{
    use PeopleTrait, PostTrait;

    public function index(Request $request)
    {
        $config = [
            'title' => __('Episodes'),
            'nav' => 'tv',
            'route' => 'episode',
            'create' => true,
            'filter' => true,
        ];

        // Filter
        $search = $request->input('q');
        $status = $request->input('status');
        $member = $request->input('member');
        $featured = $request->input('featured');
        $post_id = $request->input('post_id');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = PostEpisode::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($member, function ($query) use ($member) {
            return $query->where('member', $member);
        })->when($featured, function ($query) use ($featured) {
            return $query->where('featured', $featured);
        })->when($post_id, function ($query) use ($post_id) {
            return $query->where('post_id', $post_id);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.episode.index', compact('config', 'listings','request'));
    }

    public function create(Request $request)
    {
        $config = [
            'title' => __('TV Show'),
            'route' => 'episode',
            'nav' => 'tv',
        ];

        $tabs = [
            'overview' => __('Overview'),
            'video' => __('Video'),
            'subtitle' => __('Subtitle'),
            'advanced' => __('Advanced')
        ];
        $posts = Post::where('type', 'tv')->get();
        $countries = Country::where('subtitle','active')->get();
        return view('admin.episode.form', compact('config', 'tabs', 'posts', 'request','countries'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'episode_number' => 'required|numeric'
        ]);


        $model = new PostEpisode();
        $folderDate = date('m-Y') . '/';
        if (config('settings.tmdb_image') != 'active') {
            if ($request->hasFile('image') || $request->filled('image_url')) {
                $imagename = Str::random(10);
                $imageFile = $request->image ?? $request->input('image_url');
                $uploaded_image = fileUpload($imageFile, config('attr.poster.episode_path').$folderDate.'/', config('attr.poster.episode_size_x'), config('attr.episode_size_y.size_y'), $imagename);
                fileUpload($imageFile, config('attr.poster.episode_path').$folderDate.'/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename, 'webp');
                $model->image = $uploaded_image;
            }
        }

        $season = PostSeason::findOrFail($request->input('post_season_id'));
        $model->name = $request->input('name');
        $model->episode_number = $request->input('episode_number');
        $model->season_number = $season->season_number;
        $model->overview = $request->input('overview');
        $model->post_id = $request->post_id;
        $model->post_season_id = $request->input('post_season_id');
        $model->runtime = $request->input('runtime');
        $model->quality = $request->input('quality');
        $model->view = $request->input('view', '0');
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->featured = $request->input('featured', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();

        PostEpisodeJob::dispatch($model,$request->send_notification)->afterResponse();

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

        return redirect()->route('admin.episode.index')->with('success', __(':title created', ['title' => __('Episode')]));
    }


    public function edit($id)
    {
        $config = [
            'title' => __('TV Show'),
            'route' => 'episode',
            'nav' => 'tv',
        ];


        $listing = PostEpisode::where('id', $id)->firstOrFail() ?? abort(404);

        $tabs = [
            'overview' => __('Overview'),
            'video' => __('Video'),
            'subtitle' => __('Subtitle'),
            'advanced' => __('Advanced')
        ];

        $fetch = array();

        $fetch['data'] = $this->episodeFetch($listing);
        foreach ($listing->videos as $video) {
            $fetch['videos'][] = $this->videosFetch($video);
        }
        foreach ($listing->downloads as $download) {
            $fetch['videos'][] = $this->videosFetch($download);
        }
        foreach ($listing->subtitles as $subtitle) {
            $fetch['subtitles'][] = $this->subtitlesFetch($subtitle);
        }

        $countries = Country::where('subtitle','active')->get();
        return view('admin.episode.form', compact('config', 'listing', 'tabs', 'fetch','countries'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'episode_number' => 'required|numeric'
        ]);

        $model = PostEpisode::findOrFail($id);

        $folderDate = $model->created_at->translatedFormat('m-Y') . '/';
        if ($request->hasFile('image') || $request->input('image_url')) {
            $imagename = Str::random(10);
            $imageFile = $request->image ?? $request->input('image_url');
            $uploaded_image = fileUpload($imageFile, config('attr.poster.episode_path').$folderDate.'/', config('attr.poster.episode_size_x'), config('attr.episode_size_y.size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.episode_path').$folderDate.'/', config('attr.poster.episode_size_x'), config('attr.poster.episode_size_y'), $imagename, 'webp');
            $model->image = $uploaded_image;
        }

        $season = PostSeason::findOrFail($request->input('post_season_id'));

        $model->name = $request->input('name');
        $model->episode_number = $request->input('episode_number');
        $model->season_number = $season->season_number;
        $model->overview = $request->input('overview');
        $model->post_season_id = $request->input('post_season_id');
        $model->runtime = $request->input('runtime');
        $model->quality = $request->input('quality');
        $model->view = $request->input('view', '0');
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->featured = $request->input('featured', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();

        PostEpisodeJob::dispatch($model,$request->send_notification)->afterResponse();

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
                    $model->videos()->create(array('type' => $key['type'], 'link' => $key['link'], 'label' => $key['label']));
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

        return redirect()->route('admin.episode.edit', $model->id)->with('success', __(':title updated', ['title' => __('Episode')]));
    }

    public function destroy($id)
    {
        PostEpisode::find($id)->delete();

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
