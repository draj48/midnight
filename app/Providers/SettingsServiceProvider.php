<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Settings;
use App\Models\Menu;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Factory $cache, Settings $settings, Menu $menus)
    {
        if (env('APP_ENV') != 'install' AND Schema::hasTable('settings')) {
            $settings = $cache->rememberForever('settings', function () use ($settings) {
                return $settings->pluck('val', 'name')->all();
            });
            config()->set('settings', $settings);


            $menus = Cache::rememberForever('menus', function () {
                return Menu::where('status','active')->orderby('sortable','asc')->limit(16)->get();
            });
            config()->set('menus', $menus);

            $pages = Cache::rememberForever('pages', function () {
                return Page::where('featured','active')->where('status','publish')->orderby('id','desc')->limit(6)->get();
            });
            config()->set('pages', $pages);
        }
    }
}
