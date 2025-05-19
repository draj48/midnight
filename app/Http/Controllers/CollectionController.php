<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $listings = new Collection();
        $listings = $listings->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));

        // Seo

        $config['title'] = config('settings.collections_title');
        $config['description'] = config('settings.collections_description');


        return view('collection.index', compact('config', 'listings', 'request'));
    }

    public function show(Request $request,$slug) {

        $listing = Collection::withCount(['games'])->where('slug', $slug)->firstOrFail() ?? abort(404);

        $new = array(
            $listing->title,
            $listing->description
        );
        $old = array('[title]', '[description]');

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.collection_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.collection_description'))));

        return view('collection.show', compact('config', 'listing'));
    }
}
