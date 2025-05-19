<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Genre;
use App\Models\People;
use App\Models\Post;
use App\Models\PostEpisode;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {

        $listings['post']       = Post::where('status','publish')->count();
        $listings['episode']    = PostEpisode::where('status','publish')->count();
        $listings['genre']      = Genre::count();
        $listings['people']     = People::count();
        $listings['blog']       = Article::where('status','publish')->get();

        return response()->view('sitemap.index', [
            'listings' => $listings,
        ])->header('Content-Type', 'text/xml');
    }
    public function main(Request $request)
    {
        return response()->view('sitemap.main')->header('Content-Type', 'text/xml');
    }
    public function post(Request $request,$page)
    {

        $listings       = Post::where('status','publish')->paginate(config('attr.sitemap'), ['*'], 'page', $page);

        return response()->view('sitemap.post', [
            'listings' => $listings,
        ])->header('Content-Type', 'text/xml');
    }
    public function genre(Request $request,$page)
    {
        $listings       = Genre::paginate(config('attr.sitemap'), ['*'], 'page', $page);
        return response()->view('sitemap.genre', [
            'listings' => $listings,
        ])->header('Content-Type', 'text/xml');
    }
    public function episode(Request $request,$page)
    {
        $listings       = PostEpisode::where('status','publish')->paginate(config('attr.sitemap'), ['*'], 'page', $page);
        return response()->view('sitemap.episode', [
            'listings' => $listings,
        ])->header('Content-Type', 'text/xml');
    }
    public function people(Request $request,$page)
    {
        $listings       = People::paginate(config('attr.sitemap'), ['*'], 'page', $page);
        return response()->view('sitemap.people', [
            'listings' => $listings,
        ])->header('Content-Type', 'text/xml');
    }
}
