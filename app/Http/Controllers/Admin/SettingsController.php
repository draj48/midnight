<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;
use App\Models\Settings;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SettingsController extends Controller
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
                'icon' => 'settings',
            ],
            'seo' => [
                'title' => 'Seo',
                'nav' => 'seo',
                'icon' => 'link',
            ],
            'email' => [
                'title' => 'Email',
                'nav' => 'email',
                'icon' => 'user',
            ],
            'payment' => [
                'title' => 'Payment',
                'nav' => 'payment',
                'icon' => 'finance',
            ],
            'api' => [
                'title' => 'Api',
                'nav' => 'api',
                'icon' => 'genre',
            ]
        ];
        $languages = Language::get();

        return view('admin.settings.index', compact('config', 'tab', 'languages'));
    }

    public function update(Request $request, Factory $cache, Settings $settings)
    {
        if ($request->isMethod('post')) {

            $save_data = [
                'site_name',
                'site_about',
                'language',
                'custom_code',
                'register',
                'comment',
                'comment_status',
                'history',
                'cookie',
                'player',
                'subscription',
                'request_status',
                'request_member',
                'sidenav_featured',
                'landing',
                'preloader',
                'terms_url',
                'privacy_url',
                'cookie_url',
                'facebook',
                'twitter',
                'instagram',
                'youtube',
                'footer_description',
                'landing_title',
                'landing_description',
                'landing_body',

                'title',
                'description',
                'browse_title',
                'browse_description',
                'movies_title',
                'movies_description',
                'tvshows_title',
                'tvshows_description',
                'genre_title',
                'genre_description',
                'country_title',
                'country_description',
                'movie_title',
                'movie_description',
                'tvshow_title',
                'tvshow_description',
                'episode_title',
                'episode_description',
                'tag_title',
                'tag_description',
                'search_title',
                'search_description',
                'trending_title',
                'trending_description',
                'topimdb_title',
                'topimdb_description',
                'broadcasts_title',
                'broadcasts_description',
                'broadcast_title',
                'broadcast_description',
                'peoples_title',
                'peoples_description',
                'people_title',
                'people_description',
                'collections_title',
                'collections_description',
                'collection_title',
                'collection_description',
                'blog_title',
                'blog_description',
                'article_title',
                'article_description',
                'profile_title',
                'profile_description',
                'page_title',
                'page_description',

                'promote_link',
                'promote_text',

                // Payment
                'paypal',
                'paypal_mode',
                'paypal_client_id',
                'paypal_secret',
                'paypal_webhook_id',
                'stripe',
                'stripe_mode',
                'stripe_key',
                'stripe_secret',
                'stripe_signing_secret',
                'bank',
                'bank_detail',
            ];

            $static_path = public_path('static/img/');

            if (!\File::exists($static_path)) {
                \File::makeDirectory($static_path, 0755, true);
            }

            // Logo
            if ($request->hasFile('logo')) {
                $extension = $request->file('logo')->getClientOriginalExtension();
                $logo = 'logo-' . time() . '.' . $extension;

                if ($request->file('logo')->move($static_path, $logo)) {
                    if (config('settings.logo') and \File::exists($static_path . config('settings.logo'))) {
                        unlink($static_path . config('settings.logo'));
                    }
                }
                update_settings('logo', $logo);
            }

            // Dark Logo
            if ($request->hasFile('dark_logo')) {
                $extension = $request->file('dark_logo')->getClientOriginalExtension();
                $dark_logo = 'dark-logo-' . time() . '.' . $extension;

                if ($request->file('dark_logo')->move($static_path, $dark_logo)) {
                    if (config('settings.dark_logo') and \File::exists($static_path . config('settings.dark_logo'))) {
                        unlink($static_path . config('settings.dark_logo'));
                    }
                }
                update_settings('dark_logo', $dark_logo);
            }
            // Favicon
            if ($request->hasFile('favicon')) {
                foreach (config('attr.favicon.sizes') as $size => $favicon) {
                    @unlink(public_path(config('attr.favicon.path')) . $favicon);
                    $uploaded_image = fileUpload($request->file('favicon'), config('attr.favicon.path'), $size, $size, $favicon);
                }
            }
            $manifest = [
                'name' => $request->site_name,
                'short_name' => $request->site_name,
                'icons' => [
                    [
                        "src" => asset(config('attr.favicon.path')) . "/android-chrome-192x192.png",
                        "sizes" => "192x192",
                        "type" => "image/png"
                    ],
                    [
                        "src" => asset(config('attr.favicon.path')) . "/android-chrome-512x512.png",
                        "sizes" => "512x512",
                        "type" => "image/png"
                    ]
                ],
                "theme_color" => "#ffffff",
                "background_color" => "#ffffff",
                "display" => "fullscreen",
                "form_factor" => "wide",
                "start_url" => "/"
            ];

            \File::put('site.webmanifest', json_encode($manifest,JSON_PRETTY_PRINT));
            foreach ($save_data as $item) {
                update_settings($item, $request->$item);
            }

            // Dark Logo
            if ($request->hasFile('GOOGLE_P12')) {

                if ($request->file('GOOGLE_P12')->move(storage_path('app/analytics'), $request->file('GOOGLE_P12')->getClientOriginalName())) {

                }
            }
            $laravel_config = [
                "MAIL_HOST",
                "MAIL_PORT",
                "MAIL_USERNAME",
                "MAIL_PASSWORD",
                "MAIL_ENCRYPTION",
                "MAIL_FROM_ADDRESS",
                "MAIL_FROM_NAME",
                "ONESIGNAL_APP_ID",
                "ONESIGNAL_REST_API_KEY",
                "GOOGLE_CLIENT_ID",
                "GOOGLE_CLIENT_SECRET",
                "GOOGLE_REDIRECT_URI",
                "GOOGLE_P12",
                "ANALYTICS_PROPERTY_ID",
            ];
            $file = DotenvEditor::autoBackup(false);
            foreach ($laravel_config as $key) {
                if ($key == 'GOOGLE_P12') {
                    if($request->has('GOOGLE_P12')) {
                        $file = DotenvEditor::setKey($key, $request->file('GOOGLE_P12')->getClientOriginalName());
                    } else {
                        $file = DotenvEditor::setKey($key, env('GOOGLE_P12'));
                    }
                } else {
                    $file = DotenvEditor::setKey($key, $request->$key);
                }
            }
            $file->save();

            Cache::forget('settings');
            Cache::flush();
            return redirect()->back()->with('success', __('Changes Saved'));
        }
    }
}
