<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\RequestPost;
use Illuminate\Http\Request;

class RequestPostController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Request'),
            'heading' => __('Request'),
            'nav' => 'request',
            'route' => 'request',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = RequestPost::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'desc')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.request.index', compact('config', 'listings'));
    }
    public function destroy($id)
    {
        RequestPost::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
