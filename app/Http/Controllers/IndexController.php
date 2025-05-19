<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Broadcast;
use App\Models\Collection;
use App\Models\Community;
use App\Models\Genre;
use App\Models\Module;
use App\Models\PostEpisode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        // Seo
        $config['title'] = config('settings.title');
        $config['description'] = config('settings.description');


        $modules = Module::where('status', 'active')->orderby('sortable', 'asc')->get();

        $listings = [];
        foreach ($modules as $module) {
            $limit = $module->arguments->limit ?? 10;
            if($module->slug == 'slider') {
                $listings['slider'] = Cache::rememberForever('home-slider', function () use ($limit) {
                    return Post::where('slider', 'active')->where('status','publish')->orderBy('id', 'desc')->limit($limit)->get();
                });
            } elseif($module->slug == 'movie') {
                $listings['movie'] = Cache::rememberForever('home-movie', function () use ($limit) {
                    return Post::where('type', 'movie')->where('status', 'publish')->orderBy('id', 'desc')->limit($limit ?? 16)->get();
                });
            } elseif($module->slug == 'tv') {
                $listings['tv'] = Cache::rememberForever('home-tv', function () use ($limit) {
                    return Post::where('type', 'tv')->where('status','publish')->orderby('id','desc')->limit($limit ?? 16)->get();
                });
            } elseif($module->slug == 'episode') {
                $listings['episode'] = Cache::rememberForever('home-episode', function () use ($limit) {
                    return PostEpisode::where('status','publish')->orderby('id','desc')->limit($limit ?? 16)->get();
                });
            } elseif($module->slug == 'featured') {
                $listings['featured'] = Cache::rememberForever('home-featured', function () use ($limit) {
                    return Post::where('featured', 'active')->where('status','publish')->orderby('id','desc')->limit($limit ?? 16)->get();
                });
            }elseif($module->slug == 'broadcast') {
                $listings['broadcast'] = Cache::rememberForever('home-broadcast', function () use ($limit) {
                    return Broadcast::where('status','publish')->orderby('id','desc')->limit($limit ?? 16)->get();
                });
            } elseif($module->slug == 'genre') {
                $listings['genres'] = Cache::rememberForever('home-genre', function () use ($limit) {
                    return Genre::withCount(['posts'])->where('featured', 'active')->limit(5)->get();
                });
            } elseif($module->slug == 'collection') {
                $listings['collection'] = Cache::rememberForever('home-collection', function () use ($limit) {
                    return Collection::withCount('posts')->where('featured', 'active')->orderBy('id','desc')->limit(4)->get();
                });
            } elseif($module->slug == 'blog') {
                $listings['blog'] = Cache::rememberForever('home-blog', function () use ($limit) {
                    return Article::where('featured', 'active')->orderBy('id','desc')->limit($limit)->get();
                });
            }
        }


        return view('home.index', compact('config', 'listings', 'modules'));
    }
    public function landing()
    {
        // Seo
        $config['title'] = config('settings.title');
        $config['description'] = config('settings.description');
        return view('home.landing', compact('config'));
    }
    public function search(Request $request) {
        return redirect()->route('search',$request->q);
    }
}
