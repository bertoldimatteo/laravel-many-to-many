<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Back Office
Route::middleware('auth')
->namespace('Admin') //tutti i controller saranno dentro al namespace Admin
->name('admin.') //nome della rotta
->prefix('admin') //prefisso rotta
->group(function() { // creo gruppo che richiama /admin/home che richiama il controller
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostController');
    Route::resource('categories', 'CategoryContoller');
    Route::resource('tags', 'TagController');
});

// Front Office
Route::any('{any?}', function() {
    return view('guest.home');
})->where('any', '.*');