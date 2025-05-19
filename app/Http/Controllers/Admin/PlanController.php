<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Tax;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Plans'),
            'create' => true,
            'route' => 'plan',
            'nav' => 'finance',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Plan::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.plan.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Plan'),
            'route' => 'plan',
            'nav' => 'finance',
        ];

        $coupons    = Coupon::all();
        $taxes      = Tax::all();

        return view('admin.plan.form', compact('config','taxes','coupons'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|max:255',
            'price' => 'required'
        ]);


        $model = new Plan();
        $model->price               = $request->input('price');
        $model->name                = $request->input('name');
        $model->description         = $request->input('description');
        $model->currency            = $request->input('currency');
        $model->interval            = $request->input('interval');
        $model->taxes               = $request->input('taxes');
        $model->coupons             = $request->input('coupons');

        $latestSorting = Plan::orderBy('sorting', 'ASC')->first();
        if (isset($latestSorting->id)) {
            $model->sorting = $latestSorting->sorting+1;
        } else {
            $model->sorting = '1';
        }

        $model->featured            = $request->input('featured', 'disable');
        $model->status              = $request->input('status', 'active');
        $model->save();

        return redirect()->route('admin.plan.index')->with('success', __(':title created', ['title' => $request->input('name')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Plan'),
            'route' => 'plan',
            'nav' => 'finance',
        ];

        $coupons    = Coupon::all();
        $taxes      = Tax::all();

        $listing = Plan::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.plan.form', compact('config', 'listing','taxes','coupons'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|max:255',
            'price' => 'required',
        ]);

        $model = Plan::findOrFail($id);
        $model->price               = $request->input('price');
        $model->name                = $request->input('name');
        $model->description         = $request->input('description');
        $model->currency            = $request->input('currency');
        $model->interval            = $request->input('interval');
        $model->sorting             = $request->input('sorting');
        $model->taxes               = $request->input('taxes');
        $model->coupons             = $request->input('coupons');

        $model->featured            = $request->input('featured', 'disable');
        $model->status              = $request->input('status', 'active');
        $model->save();

        return redirect()->route('admin.plan.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('name')]));
    }

    public function destroy($id)
    {
        Plan::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
