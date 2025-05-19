<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request, $username)
    {
        $listing = User::withCount(['like','log'])->where('username', $username)->firstOrFail() ?? abort(404);

        $result['log'] = $listing->log()->orderBy('created_at', 'asc')->limit(12)->get();

        // Seo
        $new = [$listing->username];
        $old = ['[username]'];

        $config['heading'] = __('Overview');
        $config['nav'] = 'profile';
        $config['title'] = trim(str_replace($old, $new, trim(config('settings.profile_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.profile_description'))));

        return view('user.index', compact('config', 'listing', 'request', 'result'));
    }

    public function liked(Request $request,$username)
    {
        $listing = User::withCount(['like'])->where('username', $username)->firstOrFail() ?? abort(404);
        $result = $listing->like()->where('reactable_type','!=','App\Models\Comment')->paginate(24);

        $config['heading'] = __('Liked');
        $config['nav'] = 'profile.liked';

        // Seo
        $new = [$listing->username];
        $old = ['[username]'];

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.profile_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.profile_description'))));

        return view('user.liked', compact('config', 'listing', 'request','result'));
    }

    public function history(Request $request)
    {
        $listing = User::withCount(['log'])->where('id', $request->user()->id)->firstOrFail() ?? abort(404);
        $result = $listing->log()->paginate(24);
        $config['heading'] = __('Watch history');
        $config['nav'] = 'profile.history';

        // Seo
        $new = [$listing->username];
        $old = ['[username]'];

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.profile_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.profile_description'))));

        return view('user.history', compact('config', 'listing', 'request','result'));
    }

    public function watchlist(Request $request)
    {
        $listing = User::withCount(['watchlist'])->where('id', $request->user()->id)->firstOrFail() ?? abort(404);

        $result = $listing->watchlist()->paginate(24);
        $config['heading'] = __('Watchlist');
        $config['nav'] = 'profile.watchlist';

        // Seo
        $new = [$listing->username];
        $old = ['[username]'];

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.profile_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.profile_description'))));

        return view('user.watchlist', compact('config', 'listing', 'request','result'));
    }

    public function settings(Request $request)
    {

        $config['title'] = __('Settings').' - '.config('settings.title');
        $config['description'] = __('Settings').' - '.config('settings.description');

        return view('user.settings', compact('config'));
    }
    public function update(Request $request) {
        $user = User::findOrFail(Auth::user()->id);
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'username' => 'required|unique:users,username,'.Auth::user()->id,
            'new_password' => 'nullable|min:5',
            'password' => ['nullable', function ($attribute, $value, $fail) use ($user) {

                if (!\Hash::check($value, $user->password)) {
                    return $fail('Wrong password');
                }
            }]
        ]);

        // Image upload
        if ($request->hasFile('avatar')) {
            $imagename = Str::random(10);
            $uploaded_image = fileUpload($request->file('avatar'), config('attr.avatar.path'), config('attr.avatar.thumb'), config('attr.avatar.thumb'), $imagename);
            $user->avatar = $uploaded_image;
        }

        // Image upload
        if ($request->hasFile('cover')) {
            $imagename = Str::random(10);
            $uploaded_image = fileUpload($request->file('cover'), config('attr.avatar.path'), config('attr.avatar.cover_x'), config('attr.avatar.cover_y'), $imagename);
            $user->cover = $uploaded_image;
        }

        if($request->has('new_password') AND Str::length($request->new_password) > 5) {
            $user->password = Hash::make($request->new_password);
        }
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->username     = $request->username;
        $user->about        = $request->about;
        $user->save();

        return redirect()->route('settings')->with('success', __(':title updated', ['title' => 'Profile']));
    }
}
