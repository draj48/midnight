<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\Post;
use App\Models\PostVideo;
use App\Traits\BroadcastTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BroadcastController extends Controller
{
    use BroadcastTrait;
    public function index(Request $request)
    {
        $config = [
            'title' => __('Live broadcasts'),
            'nav' => 'broadcast',
            'route' => 'broadcast',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Broadcast::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.broadcast.index', compact('config', 'listings'));
    }
    public function create()
    {
        $config = [
            'title' => __('Live broadcast'),
            'route' => 'broadcast',
            'nav' => 'broadcast',
        ];

        return view('admin.broadcast.form', compact('config'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);


        $model = new Broadcast();


        if ($request->hasFile('image')) {
            $imagename = Str::random(10);
            $imageFile = $request->image;
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_size_x'), config('attr.poster.broadcast_size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_size_x'), config('attr.poster.broadcast_size_y'), $imagename,'webp');

            $model->image = $uploaded_image;
        }

        if ($request->hasFile('cover')) {
            $imagename = Str::random(10);
            $imageFile = $request->cover;
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_cover_size_x'), config('attr.poster.broadcast_cover_size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_cover_size_x'), config('attr.poster.broadcast_cover_size_y'), $imagename,'webp');

            $model->cover = $uploaded_image;
        }

        $model->title = $request->input('title');
        $model->slug = SlugService::createSlug(Broadcast::class, 'slug', $request->input('title'));
        $model->overview = $request->input('overview');
        $model->view = $request->input('view', '0');
        $model->arguments       = $request->arguments;
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->featured = $request->input('featured', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();

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


        return redirect()->route('admin.broadcast.index')->with('success', __(':title created', ['title' => __('Broadcast')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Live broadcast'),
            'route' => 'broadcast',
            'nav' => 'broadcast',
        ];

        $listing = Broadcast::where('id', $id)->firstOrFail() ?? abort(404);



        $fetch = array();

        foreach ($listing->videos as $video) {
            $fetch['videos'][] = $this->videos($video);
        }

        return view('admin.broadcast.form', compact('config', 'listing', 'fetch'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255'
        ]);

        $model = Broadcast::findOrFail($id);


        if ($request->hasFile('image')) {
            $imagename = Str::random(10);
            $imageFile = $request->image;
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_size_x'), config('attr.poster.broadcast_size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_size_x'), config('attr.poster.broadcast_size_y'), $imagename,'webp');

            $model->image = $uploaded_image;
        }

        if ($request->hasFile('cover')) {
            $imagename = Str::random(10);
            $imageFile = $request->cover;
            $uploaded_image = fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_cover_size_x'), config('attr.poster.broadcast_cover_size_y'), $imagename);
            fileUpload($imageFile, config('attr.poster.path'), config('attr.poster.broadcast_cover_size_x'), config('attr.poster.broadcast_cover_size_y'), $imagename,'webp');

            $model->cover = $uploaded_image;
        }

        $model->title = $request->input('title');
        if ($model->slug != $request->input('slug')) {
            $model->slug = SlugService::createSlug(Post::class, 'slug', $request->input('slug'));
        }
        $model->overview = $request->input('overview');
        $model->view = $request->input('view', '0');
        $model->arguments       = $request->arguments;
        $model->meta_title = $request->input('meta_title');
        $model->meta_description = $request->input('meta_description');
        $model->featured = $request->input('featured', 'disable');
        $model->member = $request->input('member', 'disable');
        $model->comment = $request->input('comment', 'disable');
        $model->status = $request->input('status', 'publish');
        $model->save();

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
        return redirect()->route('admin.broadcast.edit', $model->id)->with('success', __(':title updated', ['title' => __('Broadcast')]));
    }

    public function destroy($id)
    {
        Broadcast::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
    public function videoDestroy(Request $request)
    {
        PostVideo::find($request->id)->delete();
    }
}
