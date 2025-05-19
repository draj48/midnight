<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
class PostFilter extends Component
{
    use WithPagination;
    public $param;

    public $genre = [];
    public $country = [];
    public $release;
    public $vote_average;
    public $quality;
    public $type;
    public $search;
    public $sort;
    public $page = 1;
    public $loading = true;

    public $filterOpen = false;
    public $openSort = false;

    public function mount(Request $request)
    {

        if($request->route('search')) {
            $this->search = $request->search;
        }

        if($request->route()->getName() == 'movies' AND !$request->filled('type')) {
            $this->type = 'movie';
        } elseif($request->route()->getName() == 'tvshows' AND !$request->filled('type')) {
            $this->type = 'tv';
        } elseif($request->filled('type')) {
            $this->type = $request->type;
        }
        if($request->filled('genre')) {
            $this->genre = explode(',',$request->genre);
        }
        if($request->filled('country')) {
            $this->country = explode(',',$request->country);
        }
        if ($request->route()->getName() == __('country') and $request->route()->country) {
            $countrySelect = Country::where('slug',$request->country)->first();
            $this->country[] = $countrySelect->id;
        }
        if($request->filled('quality')) {
            $this->quality = $request->quality;
        }
        if($request->filled('release')) {
            $this->release = $request->release;
        }
        if($request->filled('vote_average')) {
            $this->vote_average = $request->vote_average;
        }

        if($request->route()->getName() == 'topimdb' AND !$request->filled('sort')) {
            $this->sort = 'vote_average';
        } elseif($request->route()->getName() == 'trending' AND !$request->filled('sort')) {
            $this->sort = 'like_count';
        }

        if($request->filled('sort')) {
            $this->sort = $request->sort;
        }
        if($request->filled('page')) {
            $this->page = $request->page;
        }
        $this->loading = false;
    }

    public function render()
    {
        $listings = new Post();

        if($this->search) {
            $listings = $listings->where('title', 'like', '%' . $this->search . '%');
        }

        if($this->type) {
            $listings = $listings->where('type',$this->type);
        }
        if($this->genre) {
            $genre = $this->genre;
            $listings = $listings->whereHas('genres', function ($q) use ($genre) {
                $q->whereIn('genres.id', $genre);
            });
        }
        if($this->country) {
            $listings = $listings->whereIn('country_id',$this->country);
        }
        if ($this->release) {
            $listings = $listings->whereYear('release_date','>=',$this->release);
        }
        if ($this->vote_average) {
            $listings = $listings->where('vote_average','>=',$this->vote_average);
        }
        if ($this->quality) {
            $listings = $listings->where('quality',$this->quality);
        }
        if($this->sort) {
            $sort = config('attr.sortable')[$this->sort];
            if($this->sort == 'like_count') {

                $listings = $listings->leftJoin('reactions', function ($join) {
                    $join->on('posts.id', '=', 'reactions.reactable_id')
                        ->where('reactions.reactable_type', '=', Post::class)
                        ->where('reactions.reaction', '=', 'like');
                })
                    ->select('posts.*', DB::raw('COUNT(reactions.id) as like_count'))
                    ->groupBy('posts.id')
                    ->orderBy('like_count', 'desc');
            } else {
                $listings = $listings->orderBy($sort['type'],$sort['order']);
            }
        }else{
            $listings = $listings->orderBy('created_at','desc');
        }

        $listings = $listings->where('status','publish');
        $listings = $listings->simplePaginate(!config('settings.listing_limit') ? 24 : config('settings.listing_limit'));


        $genres = Cache::rememberForever('browse-genre', function () {
            return Genre::withCount(['posts'])->where('featured', 'active')->limit(5)->get();
        });
        $recommends = Post::orderby('vote_average','desc')->limit(9)->get();

        $this->dispatch('scrollTop');
        return view('livewire.post-filter', [
            'listings' => $listings,
            'param' => $this->param,
            'genres' => $genres,
            'recommends' => $recommends
        ]);
    }
    public function filter()
    {

        $queries = [];

        if ($this->type) {
            $queries['type'] = $this->type;
        }
        if ($this->genre) {
            $queries['genre'] = implode(',',$this->genre);
        }
        if ($this->country) {
            $queries['country'] = implode(',',$this->country);
        }
        if ($this->release) {
            $queries['release'] = $this->release;
        }
        if ($this->vote_average) {
            $queries['vote_average'] = $this->vote_average;
        }
        if ($this->quality) {
            $queries['quality'] = $this->quality;
        }
        if ($this->sort) {
            $queries['sort'] = $this->sort;
        }
        $string = Arr::query($queries);

        $this->dispatch('urlChanged', url: $string);
        $this->filterOpen = false;
        $this->openSort = false;
    }

    public function updateSort($sort)
    {
        $this->sort = $sort;
        $this->filter();
    }
}
