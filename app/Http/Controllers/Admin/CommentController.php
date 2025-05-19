<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Comments'),
            'heading' => __('Comments'),
            'nav' => 'comment',
            'route' => 'comment',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Comment::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'desc')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.comment.index', compact('config', 'listings'));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Comment'),
            'nav' => 'comment',
        ];


        $listing = Comment::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.comment.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {
        $model = Comment::findOrFail($id);
        $model->body              = $request->input('body');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('admin.comment.edit',$model->id)->with('success', __(':title updated', ['title' => __('Comment')]));
    }
    public function destroy($id)
    {
        Comment::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
