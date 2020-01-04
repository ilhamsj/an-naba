<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/', 'PageController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
  Route::get('', 'AdminController@dashboard')->name('admin.dashboard');
  Route::get('artikel', 'AdminController@articles')->name('admin.artikel');
  Route::get('foto', 'AdminController@files')->name('admin.foto');
  Route::get('dokumen', 'AdminController@documents')->name('admin.document');
  Route::get('galeri', 'AdminController@galleries')->name('admin.gallery');
  Route::get('review', 'AdminController@reviews')->name('admin.review');
  Route::get('user', 'AdminController@users')->name('admin.user');
  Route::get('kategori', 'AdminController@categories')->name('admin.categories');
});

Route::group(['prefix' => 'blog'], function () {
  Route::get('/', 'PageController@artikel_index')->name('user.artikel.index');
  Route::get('/{id}', 'PageController@artikel_show')->name('user.artikel.show');
});

Route::group(['prefix' => 'sitemap'], function () {
  Route::get('/', 'SitemapController@index');
  Route::get('/blog', 'SitemapController@articles');
});

Route::group(['prefix' => 'artisan'], function () {
  Route::get('/{command}', function ($command) {
    Artisan::call('migrate:fresh --'.$command);
  });
  
  Route::get('', function () {
    Artisan::call('migrate:fresh');
  });
});