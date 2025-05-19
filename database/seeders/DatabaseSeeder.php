<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Module;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        DB::table('users')->insert([
            'account_type' => 'admin',
            'name' => 'Admin Author',
            'username' => 'admin',
            'about' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('admin'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('advertisements')->insert([
            'name' => 'Watch page [ 728x90 px ]',
            'body' => '<div class="text-center pb-6"><div class="text-center mx-auto"><span class="block w-full h-auto px-3 py-2 text-xs font-medium text-center text-gray-500">Customizable ad space 💸</span><a href="https://t.me/codelugv2" class="block"><img src="https://codelug.dev/discount.png" class="rounded-lg mx-auto"></a></div></div>',
            'status' => 'draft'
        ]);
        DB::table('advertisements')->insert([
            'name' => 'Listing [ 300x250 px ]',
            'body' => '<div class="text-center pb-6"><div class="text-center mx-auto"><span class="block w-full h-auto px-3 py-2 text-xs font-medium text-center text-gray-500">Customizable ad space 💸</span><div><img src="/static/img/placeholder/300.png" class="rounded-lg mx-auto"></div></div></div>',
            'status' => 'draft'
        ]);
        DB::table('advertisements')->insert([
            'name' => 'Listing [ 728x90 px ]',
            'body' => '<div class="text-center pb-6"><div class="text-center mx-auto"><span class="block w-full h-auto px-3 py-2 text-xs font-medium text-center text-gray-500">Customizable ad space 💸</span><a href="https://t.me/codelugv2" class="block"><img src="https://codelug.dev/discount.png" class="rounded-lg mx-auto"></a></div></div>',
            'status' => 'draft'
        ]);
        DB::table('advertisements')->insert([
            'name' => 'Home listing ranges [ 728x90 px ]',
            'body' => '<div class="text-center pb-6"><div class="text-center mx-auto"><span class="block w-full h-auto px-3 py-2 text-xs font-medium text-center text-gray-500">Customizable ad space 💸</span><a href="https://t.me/codelugv2" class="block"><img src="https://codelug.dev/discount.png" class="rounded-lg mx-auto"></a></div></div>',
            'status' => 'draft'
        ]);

        $save_data = [
            'site_name' => 'watchug',
            'site_about' => 'We let you watch movies online without having to register or paying, with over 10000 Movies and TV Shows.',
            'language' => 'en',


            'title' => 'Watch the Best Movies & TV Shows — Watchug',
            'description' => 'Watchug offers a wide collection of movies, including drama, comedy, action, sci-fi, and more.',

            'browse_title' => 'Explore Best Movies & TV Shows — Watchug',
            'browse_description' => 'Unleash your cinematic curiosity with watchug extensive movie collection. Browse through a variety of genres, directors, and actors to discover new favorites.',

            'movies_title' => 'Explore Best Movies — Watchug',
            'movies_description' => 'Watchug offers a wide collection of movies, including drama, comedy, action, sci-fi, and more.',

            'tvshows_title' => 'Explore Best TV Shows — Watchug',
            'tvshows_description' => 'Watchug offers a wide collection of TV Shows, including drama, comedy, action, sci-fi, and more.',

            'genre_title' => '[genre] [sortable] Best Movies & TV Shows — Watchug',
            'genre_description' => '[genre] Best Movies & TV Shows — Watchug',

            'country_title' => '[country] [sortable] Best Movies & TV Shows — Watchug',
            'country_description' => '[country] [sortable]',

            'movie_title' => '[title] Free Watch Movie — Watchug',
            'movie_description' => '[description]',

            'tvshow_title' => '[title] Watch Movie',
            'tvshow_description' => '[description]',

            'episode_title' => '[title] Watch Movie',
            'episode_description' => '[description]',

            'tag_title' => '[tag] Movies & TV Shows — Watchug',
            'tag_description' => '[tag] Movies & TV Shows — Watchug',

            'search_title' => '[search] Movies & TV Shows — Watchug',
            'search_description' => '[search] Movies & TV Shows — Watchug',

            'trending_title' => 'Explore Trending Best TV Shows — Watchug',
            'trending_description' => 'Watchug offers a wide collection of TV Shows, including drama, comedy, action, sci-fi, and more.',

            'topimdb_title' => 'Explore Top Imdb Best TV Shows — Watchug',
            'topimdb_description' => 'Watchug offers a wide collection of TV Shows, including drama, comedy, action, sci-fi, and more.',

            'broadcasts_title' => 'Explore Best Live Broadcasts — Watchug',
            'broadcasts_description' => '[description]',

            'broadcast_title' => '[title] Watch Live Broadcast',
            'broadcast_description' => '[description]',

            'peoples_title' => '[title] Watch Movie',
            'peoples_description' => '[description]',

            'people_title' => '[title] Watch Movie',
            'people_description' => '[description]',

            'collections_title' => 'Collections — Watchug',
            'collections_description' => 'Collections — Watchug',
            'collection_title' => '[title] Collection — Watchug',
            'collection_description' => '[title] Collection — Watchug',

            'blog_title' => 'Blog — Watchug',
            'blog_description' => 'Blog — Watchug',

            'article_title' => '[title] — Watchug',
            'article_description' => '[title] — Watchug',

            'profile_title' => '[username] — Watchug',
            'profile_description' => '[username] — Watchug',

            'page_title' => '[title] — Watchug',
            'page_description' => '[title] — Watchug'
        ];

        foreach ($save_data as $key => $value) {
            update_settings($key, $value);
        }


        Cache::forget('settings');
        Cache::flush();

        $data[] = [
            'title' => 'Slider',
            'slug' => 'slider',
            'arguments' => [
                'limit' => '6'
            ]
        ];
        $data[] = [
            'title' => 'Featured',
            'slug' => 'featured',
            'arguments' => [
                'limit' => '8'
            ]
        ];
        $data[] = [
            'title' => 'Latest Movies',
            'slug' => 'movie',
            'arguments' => [
                'limit' => '16',
                'listing' => 'classic'
            ]
        ];
        $data[] = [
            'title' => 'Genre',
            'slug' => 'genre',
            'arguments' => [
                'limit' => '8'
            ]
        ];
        $data[] = [
            'title' => 'Latest TV Shows',
            'slug' => 'tv',
            'arguments' => [
                'limit' => '16',
                'listing' => 'classic'
            ]
        ];
        $data[] = [
            'title' => 'Episode Calendar',
            'slug' => 'episode',
            'arguments' => [
                'limit' => '24',
                'listing' => 'classic'
            ]
        ];
        $data[] = [
            'title' => 'Live broadcast',
            'slug' => 'broadcast',
            'arguments' => [
                'limit' => '4',
                'listing' => 'classic'
            ]
        ];
        $data[] = [
            'title' => 'Recommend\'s Collection',
            'slug' => 'collection',
            'arguments' => [
                'limit' => '4'
            ]
        ];
        $data[] = [
            'title' => 'Blog',
            'slug' => 'blog',
            'arguments' => [
                'limit' => '4'
            ]
        ];
        foreach ($data as $category) {
            $dataarray = [
                'title' => $category['title'],
                'slug' => $category['slug'],
                'arguments' => $category['arguments'],
            ];
            Module::create($dataarray);
        }

        $menudata[] = [
            'title' => 'Browse',
            'layout' => 'all',
            'route' => 'browse',
            'sortable' => '0',
            'icon' => 'browse'
        ];
        $menudata[] = [
            'title' => 'Trending',
            'layout' => 'all',
            'route' => 'trending',
            'sortable' => '1',
            'icon' => 'trending'
        ];
        $menudata[] = [
            'title' => 'Top IMDb',
            'layout' => 'all',
            'route' => 'topimdb',
            'sortable' => '2',
            'icon' => 'top'
        ];
        $menudata[] = [
            'title' => 'Movies',
            'layout' => 'all',
            'route' => 'movies',
            'sortable' => '3',
            'icon' => 'movie'
        ];
        $menudata[] = [
            'title' => 'TV Shows',
            'layout' => 'all',
            'route' => 'tvshows',
            'sortable' => '4',
            'icon' => 'tv'
        ];
        $menudata[] = [
            'title' => 'Live broadcasts',
            'layout' => 'all',
            'route' => 'broadcasts',
            'sortable' => '5',
            'icon' => 'broadcast'
        ];
        $menudata[] = [
            'title' => 'Request',
            'layout' => 'all',
            'route' => 'request',
            'sortable' => '7',
            'icon' => 'refresh'
        ];
        $menudata[] = [
            'title' => 'Collections',
            'layout' => 'all',
            'route' => 'collections',
            'sortable' => '8',
            'icon' => 'collection'
        ];
        $menudata[] = [
            'title' => 'Peoples',
            'layout' => 'all',
            'route' => 'peoples',
            'sortable' => '9',
            'icon' => 'people'
        ];
        $menudata[] = [
            'title' => 'Blog',
            'layout' => 'all',
            'route' => 'blog',
            'sortable' => '10',
            'icon' => 'blog'
        ];
        foreach ($menudata as $menu) {
            $dataarray = [
                'title' => $menu['title'],
                'layout' => $menu['layout'],
                'route' => $menu['route'],
                'icon' => $menu['icon'],
                'static' => 'active',
                'status' => 'active',
            ];
            Menu::create($dataarray);
        }

        DB::table('languages')->insert([
            'code'      => 'en',
            'direction' => 'ltr',
            'name'      => 'English'
        ]);
        DB::table('languages')->insert([
            'code'      => 'tr',
            'direction' => 'ltr',
            'name'      => 'Türkçe'
        ]);

        DB::table('languages')->insert([
            'code'      => 'de',
            'direction' => 'ltr',
            'name'      => 'Deutschland'
        ]);
        DB::table('languages')->insert([
            'code'      => 'fr',
            'direction' => 'ltr',
            'name'      => 'France'
        ]);
        DB::table('languages')->insert([
            'code'      => 'ja',
            'direction' => 'ltr',
            'name'      => '日本'
        ]);
        DB::table('languages')->insert([
            'code'      => 'ar',
            'direction' => 'rtl',
            'name'      => 'عربي'
        ]);

        $pagedata[] = [
            'title' => 'Cookie policy',
            'description' => 'Cookie policy',
            'body' => 'Cookie policy',
            'featured' => 'active',
            'status' => 'publish'
        ];
        $pagedata[] = [
            'title' => 'Privacy policy',
            'description' => 'Privacy policy',
            'body' => 'Privacy policy',
            'featured' => 'active',
            'status' => 'publish'
        ];
        $pagedata[] = [
            'title' => 'DMCA',
            'description' => 'DMCA',
            'body' => 'DMCA',
            'featured' => 'active',
            'status' => 'publish'
        ];
        $pagedata[] = [
            'title' => 'Terms of service',
            'description' => 'Terms of service',
            'body' => 'Terms of service',
            'featured' => 'disable',
            'status' => 'publish'
        ];
        foreach ($pagedata as $page) {
            $dataarray = [
                'title' => $page['title'],
                'description' => $page['description'],
                'body' => $page['body'],
                'featured' => $page['featured'],
                'status' => $page['status'],
            ];
            Page::create($dataarray);
        }
        $this->call([
            CountrySeeder::class,
            GenreSeeder::class,
            //DemoSeeder::class,
        ]);

    }
}
