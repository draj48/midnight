<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeopleCollection;
use App\Models\People;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Traits\PostTrait;
use Illuminate\Support\Str;

class PeopleController extends Controller
{
    use PostTrait;

    public function index(Request $request)
    {
        $config = [
            'title' => __('Peoples'),
            'nav' => 'management',
            'route' => 'people',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = People::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.people.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('People'),
            'nav' => 'management',
        ];

        return view('admin.people.form', compact('config'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $model = new People();

        $folderDate = date('m-Y') . '/';
        if (config('settings.tmdb_image') != 'active') {
            if ($request->hasFile('image') || $request->filled('image_url')) {
                $imagename = Str::random(10);
                $imageFile = $request->image ?? $request->input('image_url');
                $uploaded_image = fileUpload($imageFile, config('attr.people.path').$folderDate.'/', config('attr.people.size_x'), config('attr.people.size_y'), $imagename);
                fileUpload($imageFile, config('attr.people.path').$folderDate.'/', config('attr.people.size_x'), config('attr.people.size_y'), $imagename, 'webp');

                $model->image = $uploaded_image;
            }
        }

        $model->name = $request->input('name');
        $model->slug = SlugService::createSlug(People::class, 'slug', $request->input('name'));
        $model->bio = $request->input('bio');
        $model->birthday = $request->input('birthday');
        $model->death_date = $request->input('death_date');
        $model->gender = $request->input('gender');
        $model->arguments = $request->arguments;
        $model->imdb_id = $request->input('imdb_id');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->featured = $request->input('featured', 'disable');
        $model->save();

        return redirect()->route('admin.people.index')->with('success', __(':title created', ['title' => __('People')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('People'),
            'nav' => 'management',
        ];


        $listing = People::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.people.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $model = People::findOrFail($id);

        $folderDate = $model->created_at->translatedFormat('m-Y') . '/';
        if (config('settings.tmdb_image') != 'active') {
            if ($request->hasFile('image') || $request->filled('image_url')) {
                $imagename = Str::random(10);
                $imageFile = $request->image ?? $request->input('image_url');
                $uploaded_image = fileUpload($imageFile, config('attr.people.path').$folderDate.'/', config('attr.people.size_x'), config('attr.people.size_y'), $imagename);
                fileUpload($imageFile, config('attr.people.path').$folderDate.'/', config('attr.people.size_x'), config('attr.people.size_y'), $imagename, 'webp');

                $model->image = $uploaded_image;
            }
        }

        $model->name = $request->input('name');
        if ($model->slug != $request->slug) {
            $model->slug = SlugService::createSlug(People::class, 'slug', $request->input('name'));
        }
        $model->bio = $request->input('bio');
        $model->birthday = $request->input('birthday');
        $model->death_date = $request->input('death_date');
        $model->gender = $request->input('gender');
        $model->arguments = $request->arguments;
        $model->imdb_id = $request->input('imdb_id');
        $model->tmdb_id = $request->input('tmdb_id');
        $model->tmdb_image = $request->input('tmdb_image');
        $model->featured = $request->input('featured', 'disable');
        $model->save();
        return redirect()->route('admin.people.edit', $model->id)->with('success', __(':title updated', ['title' => __('People')]));
    }

    public function destroy($id)
    {
        People::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }

    public function search(Request $request)
    {
        $search = $request->q;
        return PeopleCollection::collection(People::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->limit(10)->get());
    }

    public function first(Request $request)
    {
        return $this->peoplesFetch(People::where('id', $request->id)->first());
    }
}
