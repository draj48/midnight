<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Community;
use App\Models\Country;
use App\Models\Genre;
use App\Models\People;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\Tag;
use App\Traits\PostTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Spatie\SchemaOrg\Schema;

class BrowseController extends Controller
{
    use PostTrait;

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $queries = [];

            if ($request->type) {
                $queries['type'] = $request->type;
            }
            if ($request->genre) {
                $queries['genre'] = implode(',',$request->genre);
            }
            if ($request->country) {
                $queries['country'] = implode(',',$request->country);
            }
            if ($request->release) {
                $queries['release'] = $request->release;
            }
            if ($request->vote_average) {
                $queries['vote_average'] = $request->vote_average;
            }
            if ($request->quality) {
                $queries['quality'] = $request->quality;
            }
            if ($request->sort) {
                $queries['sort'] = $request->sort;
            }
            $string = Arr::query($queries);
            return redirect()->route('browse', $string);
        }
        $new = array(
            isset($config['sortable']) ? $config['sortable'] : null,
            isset($config['category']) ? $config['category'] : null,
        );
        $old = array('[sortable]', '[category]');

        $allowedParameters = ['type', 'genre', 'country', 'release', 'vote_average', 'quality', 'page', 'sort'];
        $parameters = $request->query();

        foreach ($parameters as $key => $value) {
            if (!in_array($key, $allowedParameters)) {
                $request->query->remove($key);
            }
        }
        try {
            $validatedData = $request->validate([
                'sort' => 'max:40',
                'genre' => 'max:40',
                'country' => 'max:40',
                'release' => 'max:2050|numeric',
                'vote_average' => 'max:10',
                'quality' => 'max:10',
            ]);

        } catch (ValidationException $exception) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error'], 404);
            }

            return redirect('/404')->withInput();
        }
        $param['type'] = null;
        $param['genre'] = [];
        if ($request->route()->getName() == 'tvshows') {
            $config['type'] = 'tv';
            $param['heading'] = __('TV Shows');
            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null
            );
            $old = array('[sortable]');
            $config['title'] = trim(str_replace($old, $new, trim(config('settings.tvshows_title'))));
            $config['description'] = trim(str_replace($old, $new, trim(config('settings.tvshows_description'))));
            $config['route'] = route('tvshows');

            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('TV Shows'))
                                ->id(route('tvshows'))
                        )
                ]);

        } elseif ($request->route()->getName() == 'movies') {
            $param['type'] = 'movie';
            $param['heading'] = __('Movies');
            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null
            );
            $old = array('[sortable]');
            $config['title'] = trim(str_replace($old, $new, trim(config('settings.movies_title'))));
            $config['description'] = trim(str_replace($old, $new, trim(config('settings.movies_description'))));
            $config['route'] = route('movies');

            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('Movies'))
                                ->id(route('movies'))
                        )
                ]);

        } elseif ($request->route()->getName() == 'trending') {
            $param['heading'] = __('Trending');
            $config['sort'] = $request->sort ?? 'like_count';

            $config['title'] = trim(config('settings.trending_title'));
            $config['description'] = trim(config('settings.trending_description'));
            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('Trending'))
                                ->id(route('trending'))
                        )
                ]);
        } elseif ($request->route()->getName() == 'topimdb') {
            $param['heading'] = __('Top IMDb');
            $config['sort'] = $request->sort ?? 'vote_average';
            $config['title'] = trim(config('settings.topimdb_title'));
            $config['description'] = trim(config('settings.topimdb_description'));
            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('Top IMDb'))
                                ->id(route('topimdb'))
                        )
                ]);
        } elseif ($request->route()->getName() == __('genre') and $request->route()->genre) {
            $genre = Genre::where('slug', $request->route()->genre)->firstOrFail() ?? abort(404);
            $param['heading'] = $genre->title;
            $param['genre'][] = $genre->id;

            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null,
                $genre->title
            );
            $old = array('[sortable]', '[genre]');

            $config['title'] = $genre->meta_title ?? trim(str_replace($old, $new,
                trim(config('settings.genre_title'))));
            $config['description'] = $genre->meta_description ?? trim(str_replace($old, $new,
                trim(config('settings.genre_description'))));
            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name($genre->title)
                                ->id(route('genre', $genre->slug))
                        )
                ]);
        } elseif ($request->route()->getName() == __('country') and $request->route()->country) {
            $country = Country::where('slug', $request->route()->country)->firstOrFail() ?? abort(404);
            $param['heading'] = $country->name;
            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null,
                $country->name
            );
            $old = array('[sortable]', '[country]');

            $config['title'] = trim(str_replace($old, $new, trim(config('settings.country_title'))));
            $config['description'] = trim(str_replace($old, $new, trim(config('settings.country_description'))));
            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name($country->name)
                                ->id(route('country', $country->slug))
                        )
                ]);
        } elseif ($request->route()->getName() == 'search') {
            $param['heading'] = __('Search results for ":search"', ['search' => $request->route('search')]);
            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null,
                $request->search
            );
            $old = array('[sortable]', '[search]');

            $config['title'] = trim(str_replace($old, $new, trim(config('settings.search_title'))));
            $config['description'] = trim(str_replace($old, $new, trim(config('settings.search_description'))));

            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('Search result'))
                                ->id(route('search', $request->search))
                        )
                ]);
        } else {
            $param['heading'] = __('Browse');
            $new = array(
                $request->sort ? __(config('attr.sortable')[$request->sort]['title']) : null
            );
            $old = array('[sortable]');

            $config['title'] = trim(str_replace($old, $new, trim(config('settings.browse_title'))));
            $config['description'] = trim(str_replace($old, $new, trim(config('settings.browse_description'))));
            $config['breadcrumb'] = Schema::breadcrumbList()
                ->itemListElement([
                    Schema::listItem()
                        ->position(1)
                        ->item(
                            Schema::thing()
                                ->name(__('Home'))
                                ->id(route('index'))
                        ),
                    Schema::listItem()
                        ->position(2)
                        ->item(
                            Schema::thing()
                                ->name(__('Browse'))
                                ->id(route('browse'))
                        )
                ]);
        }


        return view('browse.index', compact('config','param', 'request'));
    }

    public function broadcasts(Request $request)
    {
        $listings = new Broadcast();

        ## SEO ##
        $config['title'] = trim(config('settings.broadcasts_title'));
        $config['description'] = trim(config('settings.broadcasts_description'));
        $config['heading'] = __('Live broadcasts');

        ## SEO ##

        $listings = $listings->orderby('id',
            'desc')->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));
        return view('browse.broadcasts', compact('config', 'listings', 'request'));
    }

    public function peoples(Request $request)
    {
        $listings = new People();
        ## SEO ##
        $config['title'] = trim(config('settings.peoples_title'));
        $config['description'] = trim(config('settings.peoples_description'));
        $config['heading'] = __('Peoples');
        ## SEO ##

        $listings = $listings->orderby('id',
            'desc')->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));

        return view('browse.peoples', compact('config', 'listings', 'request'));
    }

    public function people(Request $request, $slug)
    {
        $listing = People::where('slug', $slug)->firstOrFail() ?? abort(404);

        ## SEO ##
        $new = array(
            $listing->name
        );
        $old = array('[title]');
        $config['title'] = trim(str_replace($old, $new, trim(config('settings.people_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.people_description'))));
        ## SEO ##

        return view('browse.people', compact('config', 'listing'));
    }

    public function find(Request $request)
    {
        $config['heading'] = __('Find it now');
        $config['title'] = config('settings.people_title');
        $config['description'] = config('settings.people_description');
        ## SEO ##

        return view('browse.find', compact('config'));
    }

    public function discussions(Request $request)
    {
        $listings = Community::withCount('comment');
        $config['heading'] = __('Discussions');

        $listings = $listings->orderby('id', 'desc')->paginate(10);

        return view('browse.discussions', compact('config', 'listings', 'request'));
    }

    public function discussionStore(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $model = new Community();

        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Community::class, 'slug', $request->input('title'));
        $model->description         = $request->input('description');
        $model->post_id             = $request->input('post_id');
        $model->user_id             = $request->user()->id;
        $model->featured            = $request->input('featured','disable');
        $model->comment             = $request->input('comment','disable');
        $model->status              = $request->input('status','draft');
        $model->save();

        return redirect()->route('discussion',$model->slug)->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function discussion(Request $request, $slug)
    {
        $listing = Community::where('slug', $slug)->firstOrFail() ?? abort(404);

        $config = [
            'title' => __('Movie'),
            'route' => 'movie',
            'nav' => 'movie',
        ];
        $newests = Community::withCount('comment')->limit(6)->get();

        return view('browse.discussion', compact('config', 'listing', 'newests'));
    }


    public function request(Request $request)
    {
        $config['heading'] = __('Request');


        return view('browse.request', compact('config', 'request'));
    }

    public function requestPost(Request $request)
    {
        $config['heading'] = __('Request');

        $this->validate($request, [
            'q' => 'required|string|min:3',
        ]);

        $result = Http::get('https://api.themoviedb.org/3/search/'.$request->type.'?query='.$request->q.'&api_key='.config('settings.tmdb_api').'&language='.config('settings.tmdb_language'));
        $result = json_decode($result->getBody(), true);
        $listings = [];
        if (isset($result['results'])) {
            foreach ($result['results'] as $item) {
                if ($item['poster_path']) {
                    $listings[] = $this->tmdbFetchTrait($item, $request->type);
                }
            }
        }
        return view('browse.request', compact('config', 'request', 'listings'));
    }

    public function collection(Request $request, $slug)
    {
        $listing = Collection::where('slug', $slug)->firstOrFail() ?? abort(404);

        ## SEO ##
        $new = array(
            $listing->title
        );
        $old = array('[title]');
        $config['title'] = trim(str_replace($old, $new, trim(config('settings.collection_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.collection_description'))));

        $config['route'] = route('collections');
        $config['heading'] = __('Collections');
        ## SEO ##

        return view('browse.collection', compact('config', 'listing'));
    }

    public function collections(Request $request)
    {
        $listings = Collection::withCount('posts')->orderby('id',
            'desc')->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));

        ## SEO ##
        $config['title'] = trim(config('settings.collections_title'));
        $config['description'] = trim(config('settings.collections_description'));
        $config['heading'] = __('Collections');
        ## SEO ##
        return view('browse.collections', compact('config', 'listings'));
    }

    public function tag(Request $request, $tag)
    {
        $listing = Tag::where('slug', $tag)->firstOrFail() ?? abort(404);
        $posts = $listing->posts()->paginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));

        ## SEO ##
        $new = array(
            $listing->tag
        );
        $old = array('[tag]');
        $config['title'] = trim(str_replace($old, $new, trim(config('settings.tag_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.tag_description'))));
        ## SEO ##
        return view('browse.tag', compact('config', 'listing', 'posts'));
    }
}
