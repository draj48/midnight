<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Advertisements'),
            'heading' => __('Advertisements'),
            'index' => 'admin.advertisement.index',
            'create' => 'admin.advertisement.create',
            'nav' => 'advertisement',
            'route' => 'advertisement',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Advertisement::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.advertisement.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Advertisement'),
            'nav' => 'advertisement',
            'route' => 'advertisement',
        ];

        return view('admin.advertisement.form', compact('config'));
    }

    public function store(Request $request) {


        $model = new Advertisement();

        $model->name                = $request->input('name');
        $model->body                = $request->input('body');
        $model->user_hide           = $request->input('user_hide','disable');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('admin.advertisement.index')->with('success', __(':title created', ['title' => $request->input('name')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Advertisement'),
            'nav' => 'advertisement',
            'route' => 'advertisement',
        ];


        $listing = Advertisement::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.advertisement.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {
        $model = Advertisement::findOrFail($id);
        $model->name                = $request->input('name');
        $model->body                = $request->input('body');
        $model->user_hide           = $request->input('user_hide','disable');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('admin.advertisement.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('name')]));
    }
}
