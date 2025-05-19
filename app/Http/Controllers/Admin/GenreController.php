<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Genres'),
            'nav' => 'management',
            'route' => 'genre',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Genre::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.genre.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Genre'),
            'nav' => 'management',
            'route' => 'genre',
        ];

        return view('admin.genre.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = new Genre();

        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Genre::class, 'slug', $request->input('title'));
        $model->description         = $request->input('description');
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->icon                = $request->input('icon');
        $model->color               = $request->input('color');
        $model->featured            = $request->input('featured','disable');
        $model->save();

        Cache::flush();
        return redirect()->route('admin.genre.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Genre'),
            'nav' => 'management',
            'route' => 'genre',
        ];


        $listing = Genre::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.genre.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = Genre::findOrFail($id);
        $model->title               = $request->input('title');
        if($model->slug != $request->slug) {
            $model->slug                = SlugService::createSlug(Genre::class, 'slug', $request->input('title'));
        }
        $model->description         = $request->input('description');
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->icon                = $request->input('icon');
        $model->color               = $request->input('color');
        $model->featured            = $request->input('featured','disable');
        $model->save();

        Cache::flush();
        return redirect()->route('admin.genre.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function destroy($id)
    {
        Genre::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
