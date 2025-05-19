<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

if (config('settings.language')) {
    App::setLocale(config('settings.language'));
} else { // This is optional as Laravel will automatically set the fallback language if there is none specified
    App::setLocale('en');
}
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
if (config('settings.landing') == 'active') {
    Route::get('/', [\App\Http\Controllers\IndexController::class, 'landing'])->name('landing');
    Route::post('/', [\App\Http\Controllers\IndexController::class, 'search'])->name('landing');
    Route::get('/home', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');
} else {
    Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');
}

// Browse
Route::get(__('browse'), [App\Http\Controllers\BrowseController::class, 'index'])->name('browse');
Route::post(__('browse'), [App\Http\Controllers\BrowseController::class, 'index'])->name('browse');
Route::get(__('top-imdb'), [App\Http\Controllers\BrowseController::class, 'index'])->name('topimdb');
Route::get(__('movies'), [App\Http\Controllers\BrowseController::class, 'index'])->name('movies');
Route::get(__('anime'), [App\Http\Controllers\BrowseController::class, 'index'])->name('anime');
Route::get(__('tv-shows'), [App\Http\Controllers\BrowseController::class, 'index'])->name('tvshows');
Route::get(__('live-broadcasts'), [App\Http\Controllers\BrowseController::class, 'broadcasts'])->name('broadcasts');
Route::get(__('trending'), [App\Http\Controllers\BrowseController::class, 'index'])->name('trending');
Route::get(__('genre') . '/{genre}', [App\Http\Controllers\BrowseController::class, 'index'])->name('genre');
Route::get(__('country') . '/{country}', [App\Http\Controllers\BrowseController::class, 'index'])->name('country');
Route::get(__('search') . '/' . '{search}', [App\Http\Controllers\BrowseController::class, 'index'])->name('search');
Route::get(__('tag') . '/{tag}', [App\Http\Controllers\BrowseController::class, 'tag'])->name('tag');
Route::get(__('find-it-now'), [App\Http\Controllers\BrowseController::class, 'find'])->name('browse.find');
Route::get(__('peoples'), [App\Http\Controllers\BrowseController::class, 'community'])->name('peoples');
Route::get(__('request'), [App\Http\Controllers\BrowseController::class, 'request'])->name('request');
Route::post(__('request'), [App\Http\Controllers\BrowseController::class, 'requestPost'])->name('requestPost');

Route::get(__('movie') . '/{slug}', [App\Http\Controllers\WatchController::class, 'movie'])->name('movie');
Route::get(__('tv-show') . '/{slug}', [App\Http\Controllers\WatchController::class, 'tv'])->name('tv');
Route::get(__('episode') . '/{slug}/{season}-{episode}', [App\Http\Controllers\WatchController::class, 'episode'])->name('episode');
Route::get(__('live-broadcast') . '/{slug}', [App\Http\Controllers\WatchController::class, 'broadcast'])->name('broadcast');

Route::get(__('embed') . '/{id}', [App\Http\Controllers\WatchController::class, 'embed'])->name('embed')->middleware('hotlink');

// User
Route::get(__('profile') . '/{username}/liked', [App\Http\Controllers\UserController::class, 'liked'])->name('profile.liked');
Route::get(__('profile') . '/{username}/watchlist', [App\Http\Controllers\UserController::class, 'watchlist'])->middleware(['auth'])->name('profile.watchlist');
Route::get(__('profile') . '/{username}/community', [App\Http\Controllers\UserController::class, 'community'])->name('profile.community');
Route::get(__('profile') . '/{username}/comments', [App\Http\Controllers\UserController::class, 'comments'])->name('profile.comments');
Route::get(__('profile') . '/{username}/history', [App\Http\Controllers\UserController::class, 'history'])->middleware(['auth'])->name('profile.history');

Route::get(__('profile') . '/{username}', [App\Http\Controllers\UserController::class, 'index'])->name('profile');
Route::get(__('settings'), [App\Http\Controllers\UserController::class, 'settings'])->middleware(['auth'])->name('settings');
Route::post(__('settings'), [App\Http\Controllers\UserController::class, 'update'])->middleware(['auth', 'demo'])->name('settings.update');
Route::get(__('leaderboard'), [App\Http\Controllers\UserController::class, 'leaderboard'])->name('leaderboard');

// Subscription
Route::controller(\App\Http\Controllers\SubscriptionController::class)->middleware(['auth'])->name('subscription.')->group(function () {
    Route::get('subscription', 'index')->name('index');
    Route::get('billing', 'billing')->name('billing');
    Route::get('invoice/{id}', 'invoice')->name('invoice');
    Route::get('payment', 'payment')->name('payment');
    Route::get('payment-pending', 'pending')->name('pending');
    Route::get('payment-cancelled', 'cancelled')->name('cancelled');
    Route::get('payment-completed', 'completed')->name('completed');
    Route::post('payment', 'store');
    Route::post('subscription', 'update')->name('update')->middleware('demo');
    Route::post('billing', 'cancelSubscription')->name('cancelSubscription')->middleware('demo');
});

// Community
Route::get(__('discussions'), [App\Http\Controllers\BrowseController::class, 'discussions'])->name('discussions');
Route::get(__('discussion') . '/{slug}', [App\Http\Controllers\BrowseController::class, 'discussion'])->name('discussion');
Route::post(__('create-discussion'), [App\Http\Controllers\BrowseController::class, 'discussionStore'])->name('discussions.create');
// People
Route::get(__('peoples'), [App\Http\Controllers\BrowseController::class, 'peoples'])->name('peoples');
Route::get(__('people') . '/{slug}', [App\Http\Controllers\BrowseController::class, 'people'])->name('people');

// Collection
Route::get(__('collections'), [App\Http\Controllers\BrowseController::class, 'collections'])->name('collections');
Route::get(__('collection') . '/{slug}', [App\Http\Controllers\BrowseController::class, 'collection'])->name('collection');

// Blog
Route::get(__('blog'), [App\Http\Controllers\ArticleController::class, 'index'])->name('blog');
Route::get(__('article') . '/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article');

// Page
Route::get(__('page') . '/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page');
Route::get(__('contact'), [App\Http\Controllers\PageController::class, 'contact'])->name('contact');
Route::post(__('contact'), [App\Http\Controllers\PageController::class, 'contactmail'])->name('contact.submit');

// Ajax
Route::prefix('ajax')->name('ajax.')->middleware(['auth'])->group(function () {
    Route::post('reaction', [App\Http\Controllers\AjaxController::class, 'reaction'])->name('reaction');
});

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\AjaxController@switchLang']);

// Sitemap
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('sitemap_main.xml', [App\Http\Controllers\SitemapController::class, 'main'])->name('sitemap.main');
Route::get('sitemap_post_{page}.xml', [App\Http\Controllers\SitemapController::class, 'post'])->name('sitemap.post');
Route::get('sitemap_episode_{page}.xml', [App\Http\Controllers\SitemapController::class, 'episode'])->name('sitemap.episode');
Route::get('sitemap_people_{page}.xml', [App\Http\Controllers\SitemapController::class, 'people'])->name('sitemap.people');
Route::get('sitemap_genre_{page}.xml', [App\Http\Controllers\SitemapController::class, 'genre'])->name('sitemap.genre');

// Webhook routes

Route::post('webhooks/paypal', [\App\Http\Controllers\WebhookController::class, 'paypal'])->name('webhooks.paypal');
Route::post('webhooks/stripe', [\App\Http\Controllers\WebhookController::class, 'stripe'])->name('webhooks.stripe');

// Install
Route::controller(App\Http\Controllers\InstallController::class)->name('install.')->group(function () {
    Route::get('install/index', 'index')->name('index');
    Route::get('install/config', 'config')->name('config');
    Route::get('install/complete', 'complete')->name('complete');
    Route::post('install/config', 'store')->name('store');
});
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
