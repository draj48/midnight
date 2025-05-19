<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Blog'),
            'heading' => __('Blog'),
            'route' => 'article',
            'nav' => 'community',
            'create' => true,
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Article::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', $sort)->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.article.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Article'),
            'heading' => __('Article'),
            'nav' => 'community',
        ];

        return view('admin.article.form', compact('config'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|max:255',
            'body' => 'required'
        ]);


        $model = new Article();

        if ($request->hasFile('image')) {
            $imagename = Str::random(10);
            $uploaded_image = fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.large_x'), config('attr.article.large_y'), $imagename);
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.large_x'), config('attr.article.large_y'), $imagename,'webp');
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.thumb_size_x'), config('attr.article.thumb_size_y'), 'thumb-' . $imagename);
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.thumb_size_x'), config('attr.article.thumb_size_y'), 'thumb-' . $imagename,'webp');

            $model->image = $uploaded_image;
        }

        $model->title               = $request->input('title');
        $model->slug                = SlugService::createSlug(Article::class, 'slug', $request->input('title'));
        $model->description         = $request->input('description');
        $model->body                = $request->body;
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->status              = $request->input('status', 'publish');
        $model->featured            = $request->input('featured', 'disable');
        $model->save();

        $tagArray = array();
        foreach (explode(',', $request->input('tag')) as $tag) {
            if ($tag) {
                $tagComponent = Tag::where('type','article')->firstorcreate(array('tag' => $tag, 'type' => 'article'));
                $tagArray[$tagComponent->id] = ['article_id' => $model->id, 'tagged_id' => $tagComponent->id];
            }
        }
        $model->tags()->sync($tagArray);
        return redirect()->route('admin.article.index')->with('success', __(':title created', ['title' => $request->input('title')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Article'),
            'heading' => __('Article'),
            'nav' => 'community',
        ];


        $listing = Article::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.article.form', compact('config', 'listing'));
    }
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|max:255',
            'body' => 'required'
        ]);

        $model = Article::findOrFail($id);
        $model->title               = $request->input('title');

        if ($request->hasFile('image')) {
            $imagename = Str::random(10);
            $uploaded_image = fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.large_x'), config('attr.article.large_y'), $imagename);
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.large_x'), config('attr.article.large_y'), $imagename,'webp');
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.thumb_size_x'), config('attr.article.thumb_size_y'), 'thumb-' . $imagename);
            fileUpload($request->file('image'), config('attr.article.path'), config('attr.article.thumb_size_x'), config('attr.article.thumb_size_y'), 'thumb-' . $imagename,'webp');

            $model->image = $uploaded_image;
        }

        if ($model->slug != $request->input('slug')) {
            $model->slug = SlugService::createSlug(Article::class, 'slug', $request->input('slug'));
        }

        $model->description         = $request->input('description');
        $model->body                = $request->body;
        $model->meta_title          = $request->input('meta_title');
        $model->meta_description    = $request->input('meta_description');
        $model->status              = $request->input('status', 'publish');
        $model->featured            = $request->input('featured', 'disable');
        $model->save();



        $tagArray = array();
        foreach (explode(',', $request->input('tag')) as $tag) {
            if ($tag) {
                $tagComponent = Tag::firstorcreate(array('tag' => $tag, 'type' => 'article'));
                $tagArray[$tagComponent->id] = ['article_id' => $model->id, 'tagged_id' => $tagComponent->id];
            }
        }
        $model->tags()->sync($tagArray);

        return redirect()->route('admin.article.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('title')]));
    }

    public function destroy($id)
    {
        Article::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }

}
