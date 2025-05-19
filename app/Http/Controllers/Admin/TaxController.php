<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Taxes'),
            'create' => true,
            'route' => 'tax',
            'nav' => 'finance',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Tax::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.tax.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Tax'),
            'route' => 'tax',
            'nav' => 'finance',
        ];

        return view('admin.tax.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'type' => 'required',
        ]);

        $model = new Tax();

        $model->name            = $request->input('name');
        $model->type            = $request->input('type');
        $model->percentage      = $request->input('percentage');
        $model->regions         = $request->input('regions');

        $model->save();

        return redirect()->route('admin.tax.index')->with('success', __(':title created', ['title' => $request->input('name')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Tax'),
            'route' => 'tax',
            'nav' => 'finance',
        ];


        $listing = Tax::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.tax.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'type' => 'required',
        ]);

        $model = Tax::findOrFail($id);
        $model->name            = $request->input('name');
        $model->type            = $request->input('type');
        $model->percentage      = $request->input('percentage');
        $model->regions         = $request->input('regions');

        $model->save();

        return redirect()->route('admin.tax.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('name')]));
    }

    public function destroy($id)
    {
        Tax::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
