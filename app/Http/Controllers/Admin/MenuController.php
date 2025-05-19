<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Settings'),
            'nav' => 'settings',
        ];
        $menus = Menu::orderby('sortable', 'asc')->get();
        $menuFetch = [];
        foreach ($menus as $menu) {
            $menuFetch[] = [
                'id' => $menu->id,
                'title' => $menu->title,
                'layout' => $menu->layout,
                'url' => $menu->url,
                'static' => $menu->static,
                'sortable' => $menu->sortable,
                'status' => $menu->status,
            ];
        }
        return view('admin.menu.index', compact('config', 'menus','menuFetch'));
    }

    public function update(Request $request)
    {
        foreach ($request->menu as $menu) {
            if (isset($menu['id'])) {
                $model = Menu::find($menu['id']);
                $model->title = $menu['title'];
                $model->url = $menu['url'];
                $model->layout = $menu['layout'];
                $model->sortable = $menu['sortable'];
                $model->status = $menu['status'] ?? 'disable';
                $model->save();
            } else {
                $model = new Menu();
                $model->title = $menu['title'];
                $model->url = $menu['url'];
                $model->layout = $menu['layout'];
                $model->sortable = $menu['sortable'];
                $model->status = $menu['status'] ?? 'disable';
                $model->save();
            }
        }
        Cache::forget('settings');
        Cache::flush();
        return redirect()->route('admin.menu.index')->with('success', __(':title updated', ['title' => __('Menu')]));
    }
    public function destroy(Request $request)
    {
        Menu::where('static','disable')->find($request->id)->delete();
    }
}
