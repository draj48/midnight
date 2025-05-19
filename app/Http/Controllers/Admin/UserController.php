<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Users'),
            'heading' => __('Users'),
            'create' => true,
            'nav' => 'community',
            'route' => 'user',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = User::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.user.index', compact('config', 'listings'));
    }


    public function create()
    {
        $config = [
            'title' => __('User'),
            'nav' => 'community',
        ];

        $plans      = Plan::where('status','active')->get();
        return view('admin.user.form', compact('config','plans'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255',
            'password' => 'required'
        ]);


        $model = new User();
        $model->account_type        = $request->input('account_type');
        $model->name                = $request->input('name');
        $model->username            = $request->input('username');
        $model->about               = $request->input('about');
        $model->email               = $request->input('email');
        $model->password            = Hash::make($request->password);
        $model->save();

        return redirect()->route('admin.user.index')->with('success', __(':title created', ['title' => __('User')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('User'),
            'nav' => 'community',
        ];


        $listing    = User::where('id', $id)->firstOrFail() ?? abort(404);

        $plans      = Plan::where('status','active')->get();
        return view('admin.user.form', compact('config', 'listing','plans'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255'
        ]);

        $model = User::findOrFail($id);
        $model->account_type        = $request->input('account_type');
        $model->name                = $request->input('name');
        $model->email               = $request->input('email');
        $model->username            = $request->input('username');
        $model->about               = $request->input('about');

        if($request->has('new_password') AND Str::length($request->new_password) > 5) {
            $model->password = Hash::make($request->new_password);
        }


        if($request->has('new_password') AND Str::length($request->new_password) > 5) {
            $model->password = Hash::make($request->new_password);
        }

        $model->plan_id             = $request->input('plan_id');
        $model->plan_interval       = $request->input('plan_interval');
        $model->plan_ends_at        = $request->input('plan_ends_at');
        $model->save();

        return redirect()->route('admin.user.edit',$model->id)->with('success', __(':title updated', ['title' => __('User')]));
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
