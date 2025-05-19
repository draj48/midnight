<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Module;
use App\Models\Settings;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomizeController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Settings'),
            'nav' => 'settings',
        ];
        $tab = [
            'general' => [
                'title' => 'General',
                'nav' => 'general',
                'icon' => 'setting-2',
            ],
            'customize' => [
                'title' => 'Customize',
                'nav' => 'customize',
                'icon' => 'brush-2',
            ],
            'seo' => [
                'title' => 'Seo',
                'nav' => 'seo',
                'icon' => 'link-1',
            ],
            'email' => [
                'title' => 'Email',
                'nav' => 'email',
                'icon' => 'sms-tracking',
            ],
            'api' => [
                'title' => 'Api',
                'nav' => 'api',
                'icon' => 'key',
            ]
        ];
        $modules = Module::orderby('sortable', 'asc')->get();
        return view('admin.customize.index', compact('config', 'tab', 'modules'));
    }

    public function update(Request $request)
    {
        $save_data = [
            'color',
            'palette',
            'layout',
            'footer_type',
            'listing_limit',
            'listing_recommend_limit',
            'listing_type',
            'listing_filter',
            'listing_genre',
            'poster_type',
            'top_week',
            'show_titlesub'
        ];
        foreach ($save_data as $item) {
            update_settings($item, $request->$item);
        }

        foreach ($request->module as $module) {
            if (isset($module['id'])) {
                $model = Module::find($module['id']);
                $model->title = $module['title'];
                $model->arguments = $module['arguments'];
                $model->sortable = $module['sortable'];
                $model->status = $module['status'] ?? 'disable';
                $model->save();
            }
        }
        Cache::forget('settings');
        Cache::flush();
        return redirect()->route('admin.customize.index')->with('success', __(':title updated', ['title' => __('Customize')]));
    }
}
