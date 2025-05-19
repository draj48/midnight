<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Countries'),
            'nav' => 'settings',
            'route' => 'country',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Country::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.country.index', compact('config', 'listings'));
    }
    public function create()
    {
        $config = [
            'title' => __('Country'),
            'nav' => 'settings',
            'route' => 'country',
        ];

        return view('admin.country.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:25',
        ]);

        $model = new Country();

        $model->name                = $request->input('name');
        $model->slug                = SlugService::createSlug(Country::class, 'slug', $request->input('name'));
        $model->code                = $request->input('code');
        $model->flag                = $request->input('flag');
        $model->subtitle            = $request->input('subtitle','disable');
        $model->filter              = $request->input('filter','disable');
        $model->save();

        return redirect()->route('admin.category.index')->with('success', __(':title created', ['title' => __('Country')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Country'),
            'nav' => 'settings',
            'route' => 'country',
        ];


        $listing = Country::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.country.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:25',
        ]);

        $model = Country::findOrFail($id);
        $model->name               = $request->input('name');
        if($model->slug != $request->slug) {
            $model->slug                = SlugService::createSlug(Country::class, 'slug', $request->input('name'));
        }
        $model->code                = $request->input('code');
        $model->flag                = $request->input('flag');
        $model->subtitle            = $request->input('subtitle','disable');
        $model->filter              = $request->input('filter','disable');
        $model->save();

        return redirect()->route('admin.country.edit',$model->id)->with('success', __(':title updated', ['title' => __('Country')]));
    }

    public function destroy($id)
    {
        Country::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
