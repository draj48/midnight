<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Auth;

class SocialController extends Controller
{
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookCallback() {
        try {

            $user = Socialite::driver('facebook')->user();
            //dd($user);
            $isUser = User::where('email', $user->email)->first();

            if($isUser){
                $isUser->socialite_type = 'facebook';
                $isUser->socialite_id = $user->id;
                $isUser->save();
                Auth::login($isUser);
                return redirect('/');
            }else{
                // Image upload
                $imagename = Str::random(10);
                $uploaded_image = fileUpload($user->avatar, config('attr.avatar.path'), config('attr.avatar.thumb'), config('attr.avatar.thumb'), $imagename);
                $createUser = User::updateOrCreate([
                    'name' => $user->name,
                    'username' => Str::slug($user->name.rand(1,100), '-'),
                    'email' => $user->email,
                    'avatar' => $uploaded_image,
                    'password' => encrypt($user->id.'@'.$user->email),
                    'socialite_type' => 'facebook',
                    'socialite_id' => $user->id
                ]);
                Auth::login($createUser);
                return redirect('/');
            }

        } catch (Exception $exception) {
            return redirect()->route('index')->with('success', $exception->getMessage());
        }
    }
    public function google()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback() {
        try {

            $user = Socialite::driver('google')->user();
            //dd($user);
            $isUser = User::where('email', $user->email)->first();

            if($isUser){
                $isUser->socialite_type = 'google';
                $isUser->socialite_id = $user->id;
                $isUser->save();
                Auth::login($isUser);
                return redirect('/');
            }else{
                // Image upload
                $imagename = Str::random(10);
                $uploaded_image = fileUpload($user->avatar, config('attr.avatar.path'), config('attr.avatar.thumb'), config('attr.avatar.thumb'), $imagename);
                $createUser = User::updateOrCreate([
                    'name' => $user->name,
                    'username' => Str::slug($user->name.rand(1,100), '-'),
                    'email' => $user->email,
                    'avatar' => $uploaded_image,
                    'password' => encrypt($user->id.'@'.$user->email),
                    'socialite_type' => 'google',
                    'socialite_id' => $user->id
                ]);
                Auth::login($createUser);
                return redirect('/');
            }

        } catch (Exception $exception) {
            return redirect()->route('index')->with('success', $exception->getMessage());
        }
    }
}