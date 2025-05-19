<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Communities'),
            'nav' => 'community',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Community::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.community.index', compact('config', 'listings'));
    }
    public function create()
    {
        $config = [
            'title' => __('Community'),
            'nav' => 'community',
        ];

        return view('admin.community.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = new Community();

        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Community::class, 'slug', $request->input('title'));
        $model->description         = $request->input('description');
        $model->post_id             = $request->input('post_id');
        $model->user_id             = $request->user()->id;
        $model->featured            = $request->input('featured','disable');
        $model->comment             = $request->input('comment','disable');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('admin.community.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Community'),
            'nav' => 'community',
        ];


        $listing = Community::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.community.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = Community::findOrFail($id);
        $model->title               = $request->input('title');
        if($model->slug != $request->slug) {
            $model->slug                = SlugService::createSlug(Community::class, 'slug', $request->input('title'));
        }
        $model->description         = $request->input('description');
        $model->post_id             = $request->input('post_id');
        $model->user_id             = $request->user()->id;
        $model->featured            = $request->input('featured','disable');
        $model->comment             = $request->input('comment','disable');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('admin.community.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function destroy($id)
    {
        Community::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
