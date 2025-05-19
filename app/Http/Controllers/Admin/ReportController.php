<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Reports'),
            'heading' => __('Reports'),
            'nav' => 'report',
            'route' => 'report',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Report::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'desc')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.report.index', compact('config', 'listings'));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Report'),
            'nav' => 'report',
        ];


        $listing = Report::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.report.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {


        $model = Report::findOrFail($id);
        $model->status              = $request->input('status','pending');
        $model->save();

        return redirect()->route('admin.report.edit',$model->id)->with('success', __(':title updated', ['title' => __('Report')]));
    }
    public function destroy($id)
    {
        Report::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
