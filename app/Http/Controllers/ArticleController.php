<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $listings = new Article();
        $listings = $listings->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));

        // Seo

        $config['title'] = config('settings.blog_title');
        $config['description'] = config('settings.blog_description');


        return view('article.index', compact('config', 'listings', 'request'));
    }

    public function show(Request $request,$slug) {

        $listing = Article::where('slug', $slug)->firstOrFail() ?? abort(404);

        $new = array(
            $listing->title,
            $listing->description
        );
        $old = array('[title]', '[description]');

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.article_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.article_description'))));
        $config['image'] = $listing->imageurl;

        return view('article.show', compact('config', 'listing'));
    }
}
