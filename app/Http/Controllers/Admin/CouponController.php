<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Coupons'),
            'create' => true,
            'route' => 'coupon',
            'nav' => 'finance',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Coupon::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.coupon.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Coupon'),
            'route' => 'coupon',
            'nav' => 'finance',
        ];

        return view('admin.coupon.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required',
        ]);

        $model = new Coupon();

        $model->name            = $request->input('name');
        $model->code            = $request->input('code');
        $model->percentage      = $request->input('percentage');
        $model->quantity        = $request->input('quantity');

        $model->save();

        return redirect()->route('admin.coupon.index')->with('success', __(':title created', ['title' => $request->input('name')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Coupon'),
            'route' => 'coupon',
            'nav' => 'finance',
        ];


        $listing = Coupon::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.coupon.form', compact('config', 'listing'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required',
        ]);

        $model = Coupon::findOrFail($id);
        $model->name            = $request->input('name');
        $model->code            = $request->input('code');
        $model->percentage      = $request->input('percentage');
        $model->quantity        = $request->input('quantity');

        $model->save();

        return redirect()->route('admin.coupon.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('name')]));
    }

    public function destroy($id)
    {
        Coupon::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
