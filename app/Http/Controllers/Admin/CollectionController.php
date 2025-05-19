<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Post;
use App\Traits\PostTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CollectionController extends Controller
{
    use PostTrait;
    public function index(Request $request)
    {
        $config = [
            'title' => __('Collections'),
            'create' => true,
            'route' => 'collection',
            'nav' => 'community',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Collection::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.collection.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Collection'),
            'route' => 'collection',
            'nav' => 'community',
        ];

        $games = Post::get();
        return view('admin.collection.form', compact('config','games'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = new Collection();

        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Collection::class, 'slug', $request->input('title'));
        $model->featured            = $request->input('featured','disable');
        $model->save();
        $model->posts()->sync($request->post);

        Cache::flush();
        return redirect()->route('admin.collection.index')->with('success', __(':title created', ['title' => __('Collection')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Collection'),
            'route' => 'collection',
            'nav' => 'community',
        ];


        $listing = Collection::where('id', $id)->firstOrFail() ?? abort(404);

        $fetch = array();

        foreach ($listing->posts as $post) {
            $fetch['posts'][] = $this->postjson($post);
        }
        return view('admin.collection.form', compact('config', 'listing','fetch'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = Collection::findOrFail($id);
        $model->title               = $request->input('title');
        if($model->slug != $request->slug) {
            $model->slug                = SlugService::createSlug(Collection::class, 'slug', $request->input('title'));
        }
        $model->featured            = $request->input('featured','disable');
        $model->save();

        $model->posts()->sync($request->post);
        Cache::flush();
        return redirect()->route('admin.collection.edit',$model->id)->with('success', __(':title updated', ['title' => __('Collection')]));
    }

    public function destroy($id)
    {
        Collection::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
