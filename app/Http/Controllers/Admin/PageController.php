<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Pages'),
            'heading' => __('Pages'),
            'create' => true,
            'nav' => 'settings',
            'route' => 'page',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Page::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.page.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Page'),
            'heading' => __('Create Page'),
            'nav' => 'settings',
            'route' => 'page',
        ];

        return view('admin.page.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|max:255',
            'body' => 'required'
        ]);


        $model = new Page();
        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Page::class, 'slug', $request->input('title'));
        $model->description         = $request->input('description');
        $model->body                = $request->body;
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->featured            = $request->input('featured', 'active');
        $model->status              = $request->input('status', 'publish');
        $model->save();

        return redirect()->route('admin.page.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Page'),
            'heading' => __('Edit Page'),
            'nav' => 'settings',
            'route' => 'page',
        ];


        $listing = Page::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.page.form', compact('config', 'listing'));
    }
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|max:255',
            'body' => 'required'
        ]);

        $model = Page::findOrFail($id);
        $model->title               = $request->input('title');

        if ($model->slug != $request->input('slug')) {
            $model->slug = SlugService::createSlug(Page::class, 'slug', $request->input('slug'));
        }

        $model->description         = $request->input('description');
        $model->body                = $request->body;
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->featured            = $request->input('featured', 'active');
        $model->status              = $request->input('status', 'publish');
        $model->save();

        return redirect()->route('admin.page.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function destroy($id)
    {
        Page::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }

}
