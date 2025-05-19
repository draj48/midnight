<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth','auth.admin'])->group(function () {

    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');
    Route::controller(\App\Http\Controllers\Admin\IndexController::class)->name('index.')->group(function () {
        Route::get('post-json', 'search')->name('search');
        Route::get('post-first', 'first')->name('first');
    });

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        return redirect()->route('admin.index')->with('success', __('Cache cleared'));
    })->name('cache.clear');

    // Settings
    Route::controller(\App\Http\Controllers\Admin\SettingsController::class)->name('settings.')->group(function () {
        Route::get('settings', 'index')->name('index');
        Route::post('settings', 'update')->name('update')->middleware('demo');
    });

    // Customize
    Route::controller(\App\Http\Controllers\Admin\CustomizeController::class)->name('customize.')->group(function () {
        Route::get('customize', 'index')->name('index');
        Route::post('customize', 'update')->name('update')->middleware('demo');
    });

    // Updater
    Route::controller(\App\Http\Controllers\Admin\UpdaterController::class)->name('updater.')->group(function () {
        Route::get('updater', 'index')->name('index');
        Route::post('updater', 'update')->name('update')->middleware('demo');
    });

    // Menu
    Route::controller(\App\Http\Controllers\Admin\MenuController::class)->name('menu.')->group(function () {
        Route::get('menu', 'index')->name('index');
        Route::post('menu', 'update')->name('update')->middleware('demo');
        Route::delete('menu-destroy', 'destroy')->name('destroy')->middleware('demo');
    });


    // Movie
    Route::controller(\App\Http\Controllers\Admin\MovieController::class)->name('movie.')->group(function () {
        Route::get('movies', 'index')->name('index');
        Route::get('movie', 'create')->name('create');
        Route::get('movie/{id}', 'edit')->name('edit');
        Route::post('movies/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('movie', 'store')->name('store')->middleware('demo');
        Route::post('movie-tmdb', 'tmdb')->name('tmdb')->middleware('demo');
        Route::post('movie/{id}', 'update')->name('update')->middleware('demo');
        Route::delete('movie/video-destroy', 'videoDestroy')->name('video.destroy')->middleware('demo');
        Route::delete('movie/subtitle-destroy', 'subtitleDestroy')->name('subtitle.destroy')->middleware('demo');
    });

    // TV Show
    Route::controller(\App\Http\Controllers\Admin\TvController::class)->name('tv.')->group(function () {
        Route::get('tv-shows', 'index')->name('index');
        Route::get('tv-show', 'create')->name('create');
        Route::get('tv-show/{id}', 'edit')->name('edit');
        Route::post('tv-shows/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('tv-show', 'store')->name('store');
        Route::post('tv-tmdb', 'tmdb')->name('tmdb')->middleware('demo');
        Route::post('tv-show/{id}', 'update')->name('update')->middleware('demo');
        Route::get('tv-show-json', 'search')->name('search');
        Route::delete('tv-show/season-destroy', 'seasonDestroy')->name('season.destroy');
    });

    // Episode
    Route::controller(\App\Http\Controllers\Admin\EpisodeController::class)->name('episode.')->group(function () {
        Route::get('episodes', 'index')->name('index');
        Route::get('episode', 'create')->name('create');
        Route::get('episode/{id}', 'edit')->name('edit');
        Route::post('episodes/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('episode', 'store')->name('store')->middleware('demo');
        Route::post('episode/{id}', 'update')->name('update')->middleware('demo');
        Route::delete('episode/video-destroy', 'videoDestroy')->name('video.destroy');
        Route::delete('episode/subtitle-destroy', 'subtitleDestroy')->name('subtitle.destroy');
    });

    // Live broadcast
    Route::controller(\App\Http\Controllers\Admin\BroadcastController::class)->name('broadcast.')->group(function () {
        Route::get('broadcasts', 'index')->name('index');
        Route::get('broadcast', 'create')->name('create');
        Route::get('broadcast/{id}', 'edit')->name('edit');
        Route::post('broadcasts/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('broadcast', 'store')->name('store')->middleware('demo');
        Route::post('broadcast/{id}', 'update')->name('update')->middleware('demo');
        Route::delete('broadcast/video-destroy', 'videoDestroy')->name('video.destroy');
    });

    // Genre
    Route::controller(\App\Http\Controllers\Admin\GenreController::class)->name('genre.')->group(function () {
        Route::get('genres', 'index')->name('index');
        Route::get('genre', 'create')->name('create');
        Route::get('genre/{id}', 'edit')->name('edit');
        Route::post('genres/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('genre', 'store')->name('store')->middleware('demo');
        Route::post('genre/{id}', 'update')->name('update')->middleware('demo');
    });

    // People
    Route::controller(\App\Http\Controllers\Admin\PeopleController::class)->name('people.')->group(function () {
        Route::get('peoples', 'index')->name('index');
        Route::get('people', 'create')->name('create');
        Route::get('people/{id}', 'edit')->name('edit');
        Route::post('peoples/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('people', 'store')->name('store')->middleware('demo');
        Route::post('people/{id}', 'update')->name('update')->middleware('demo');
        Route::get('people-json', 'search')->name('search');
        Route::get('people-first', 'first')->name('first');
    });

    // Page
    Route::controller(\App\Http\Controllers\Admin\PageController::class)->name('page.')->group(function () {
        Route::get('pages', 'index')->name('index');
        Route::get('page', 'create')->name('create');
        Route::get('page/{id}', 'edit')->name('edit');
        Route::post('pages/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('page', 'store')->name('store')->middleware('demo');
        Route::post('page/{id}', 'update')->name('update')->middleware('demo');
    });

    // User
    Route::controller(\App\Http\Controllers\Admin\UserController::class)->name('user.')->group(function () {
        Route::get('users', 'index')->name('index');
        Route::get('user', 'create')->name('create');
        Route::get('user/{id}', 'edit')->name('edit');
        Route::post('users/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('user', 'store')->name('store')->middleware('demo');
        Route::post('user/{id}', 'update')->name('update')->middleware('demo');
    });

    // Language
    Route::controller(\App\Http\Controllers\Admin\LanguageController::class)->name('language.')->group(function () {
        Route::get('languages', 'index')->name('index');
        Route::get('language', 'create')->name('create');
        Route::get('language/{id}', 'edit')->name('edit');
        Route::post('languages/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('language', 'store')->name('store')->middleware('demo');
        Route::post('language/{id}', 'update')->name('update')->middleware('demo');
    });

    // Plan
    Route::controller(\App\Http\Controllers\Admin\PlanController::class)->name('plan.')->group(function () {
        Route::get('plans', 'index')->name('index');
        Route::get('plan', 'create')->name('create');
        Route::get('plan/{id}', 'edit')->name('edit');
        Route::post('plans/{id}/destroy', 'destroy')->name('destroy');
        Route::post('plan', 'store')->name('store');
        Route::post('plan/{id}', 'update')->name('update');
    });

    // Tax
    Route::controller(\App\Http\Controllers\Admin\TaxController::class)->name('tax.')->group(function () {
        Route::get('taxes', 'index')->name('index');
        Route::get('tax', 'create')->name('create');
        Route::get('tax/{id}', 'edit')->name('edit');
        Route::post('taxes/{id}/destroy', 'destroy')->name('destroy');
        Route::post('tax', 'store')->name('store');
        Route::post('tax/{id}', 'update')->name('update');
    });
    // Coupon
    Route::controller(\App\Http\Controllers\Admin\CouponController::class)->name('coupon.')->group(function () {
        Route::get('coupons', 'index')->name('index');
        Route::get('coupon', 'create')->name('create');
        Route::get('coupon/{id}', 'edit')->name('edit');
        Route::post('coupons/{id}/destroy', 'destroy')->name('destroy');
        Route::post('coupon', 'store')->name('store');
        Route::post('coupon/{id}', 'update')->name('update');
    });

    // Article
    Route::controller(\App\Http\Controllers\Admin\ArticleController::class)->name('article.')->group(function () {
        Route::get('blog', 'index')->name('index');
        Route::get('article', 'create')->name('create');
        Route::get('article/{id}', 'edit')->name('edit');
        Route::post('blog/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('article', 'store')->name('store')->middleware('demo');
        Route::post('article/{id}', 'update')->name('update')->middleware('demo');
    });

    // Tool
    Route::controller(\App\Http\Controllers\Admin\ToolController::class)->name('tool.')->group(function () {
        Route::get('tools', 'index')->name('index');
    });

    // Tmdb
    Route::controller(\App\Http\Controllers\Admin\TmdbController::class)->name('tmdb.')->group(function () {
        Route::get('tmdb', 'show')->name('show');
        Route::get('tmdb-fetch', 'fetch')->name('fetch')->middleware('demo');
        Route::post('tmdb-fetch', 'fetch')->middleware('demo');
        Route::post('tmdb-fetch-single', 'tmdbSingleFetch')->name('fetchsingle')->middleware('demo');
        Route::post('tmdb-episode', 'tmdbEpisodeFetch')->name('fetchepisode')->middleware('demo');
        Route::get('tmdb-settings', 'settings')->name('settings');
        Route::post('tmdb-settings', 'update')->middleware('demo');
        Route::post('tmdb-store', 'store')->name('store')->middleware('demo');
    });

    // Onesignal
    Route::controller(\App\Http\Controllers\Admin\OnesignalController::class)->name('onesignal.')->group(function () {
        Route::get('onesignal', 'show')->name('show');
        Route::post('onesignal', 'submit')->middleware('demo');
        Route::get('onesignal-settings', 'settings')->name('settings');
        Route::post('onesignal-settings', 'update')->middleware('demo');
    });

    // Report
    Route::controller(\App\Http\Controllers\Admin\ReportController::class)->name('report.')->group(function () {
        Route::get('reports', 'index')->name('index');
        Route::get('report/{id}', 'edit')->name('edit');
        Route::post('reports/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('report/{id}', 'update')->name('update')->middleware('demo');
    });

    // RequestPost
    Route::controller(\App\Http\Controllers\Admin\RequestPostController::class)->name('request.')->group(function () {
        Route::get('requests', 'index')->name('index');
        Route::get('request/{id}', 'edit')->name('edit');
        Route::post('requests/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
    });

    // Comment
    Route::controller(\App\Http\Controllers\Admin\CommentController::class)->name('comment.')->group(function () {
        Route::get('comments', 'index')->name('index');
        Route::get('comment/{id}', 'edit')->name('edit');
        Route::post('comments/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
        Route::post('comment/{id}', 'update')->name('update')->middleware('demo');
    });

    // Collection
    Route::controller(\App\Http\Controllers\Admin\CollectionController::class)->name('collection.')->group(function () {
        Route::get('collections', 'index')->name('index');
        Route::get('collection', 'create')->name('create');
        Route::get('collection/{id}', 'edit')->name('edit');
        Route::post('collection', 'store')->name('store')->middleware('demo');
        Route::post('collection/{id}', 'update')->name('update')->middleware('demo');
        Route::post('collections/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
    });

    // Country
    Route::controller(\App\Http\Controllers\Admin\CountryController::class)->name('country.')->group(function () {
        Route::get('countries', 'index')->name('index');
        Route::get('country', 'create')->name('create');
        Route::get('country/{id}', 'edit')->name('edit');
        Route::post('country', 'store')->name('store')->middleware('demo');
        Route::post('country/{id}', 'update')->name('update')->middleware('demo');
        Route::post('countries/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
    });

    // Community
    Route::controller(\App\Http\Controllers\Admin\CommunityController::class)->name('community.')->group(function () {
        Route::get('communities', 'index')->name('index');
        Route::get('community', 'create')->name('create');
        Route::get('community/{id}', 'edit')->name('edit');
        Route::post('community', 'store')->name('store')->middleware('demo');
        Route::post('community/{id}', 'update')->name('update')->middleware('demo');
        Route::post('communities/{id}/destroy', 'destroy')->name('destroy')->middleware('demo');
    });
    // Advertisement
    Route::controller(\App\Http\Controllers\Admin\AdvertisementController::class)->name('advertisement.')->group(function () {
        Route::get('advertisements', 'index')->name('index');
        Route::get('advertisement', 'create')->name('create');
        Route::get('advertisement/{id}', 'edit')->name('edit');
        Route::post('advertisement', 'store')->name('store')->middleware('demo');
        Route::post('advertisement/{id}', 'update')->name('update')->middleware('demo');
    });


    // Payment
    Route::controller(\App\Http\Controllers\Admin\PaymentController::class)->name('payment.')->group(function () {
        Route::get('payments', 'index')->name('index');
        Route::get('payment/{id}', 'edit')->name('edit');
        Route::post('payments/{id}/destroy', 'destroy')->name('destroy');
        Route::post('payment/{id}', 'update')->name('update');
    });
});
