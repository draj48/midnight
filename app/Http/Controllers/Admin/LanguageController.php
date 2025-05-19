<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Languages'),
            'heading' => __('Languages'),
            'nav' => 'settings',
            'route' => 'language',
            'create' => true
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Language::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.language.index', compact('config', 'listings'));
    }

    public function create()
    {
        $config = [
            'title' => __('Language'),
            'nav' => 'settings',
            'route' => 'language',
        ];

        $data_results = file_get_contents(lang_path('en.json'));
        $lang = json_decode($data_results, true);

        return view('admin.language.form', compact('config','lang'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        if (file_exists(lang_path(Str::slug($request->input('code')).'.json')) and Str::slug($request->input('code')) != 'en') {
            unlink(lang_path(Str::slug($request->input('code')).'.json'));
        }

        $model = new Language();
        $model->code                = $request->input('code');
        $model->name                = $request->input('name');
        $model->save();

        $keys = $request->keys;
        $values = $request->values;
        foreach (array_combine($keys, $values) as $key => $value) {
            $n = str_replace('_', ' ', $key);
            $new[$n] = $value;
        }
        $mydata = json_encode($new);
        file_put_contents(lang_path(Str::slug($request->input('code')).'.json'), $mydata);

        return redirect()->route('admin.language.index')->with('success', __(':title created', ['title' => $request->input('name')]));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Language'),
            'nav' => 'settings',
            'route' => 'language',
        ];


        $listing = Language::where('id', $id)->firstOrFail() ?? abort(404);

        $data_results = file_get_contents(lang_path($listing->code.'.json'));
        $lang = json_decode($data_results, true);
        return view('admin.language.form', compact('config', 'listing','lang'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        if (file_exists(lang_path(Str::slug($request->input('code')).'.json')) and Str::slug($request->input('code')) != 'en') {
            unlink(lang_path(Str::slug($request->input('code')).'.json'));
        }
        $model = Language::findOrFail($id);
        $model->code                = $request->input('code');
        $model->name                = $request->input('name');
        $model->save();


        $keys = $request->keys;
        $values = $request->values;
        foreach (array_combine($keys, $values) as $key => $value) {
            $n = str_replace('_', ' ', $key);
            $new[$n] = $value;
        }
        $mydata = json_encode($new);
        file_put_contents(lang_path(Str::slug($request->input('code')).'.json'), $mydata);
        return redirect()->route('admin.language.edit',$model->id)->with('success', __(':title updated', ['title' => $request->input('name')]));
    }

    public function destroy($id)
    {
        Language::find($id)->delete();

        return redirect()->back()->with('success', __('Deleted'));
    }
}
