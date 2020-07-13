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

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', ['as' => 'login_form', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login_action', 'uses' => 'LoginController@login']);
    Route::get('register', ['as' => 'register_form', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register_action', 'uses' => 'RegisterController@register']);
});

/*
|--------------------------------------------------------------------------
| Admin section.
|--------------------------------------------------------------------------
*/
Route::group(['prefix'=>'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/', ['as' => 'admin_page_list', 'uses' => 'PageController@index']);
    Route::post('delete', ['as' => 'admin_page_delete', 'uses' => 'PageController@delete']);

    // News section.
    Route::group(['prefix'=>'pages'], function () {
        Route::get('/',            ['as' => 'admin_page_list',   'uses' => 'PageController@index']);
        Route::get('create',       ['as' => 'admin_page_create', 'uses' => 'PageController@create']);
        Route::post('store',       ['as' => 'admin_page_store',  'uses' => 'PageController@store']);
        Route::get('edit/{id}',    ['as' => 'admin_page_edit',   'uses' => 'PageController@edit']);
        Route::post('update/{id}', ['as' => 'admin_page_update', 'uses' => 'PageController@update']);
        Route::post('delete',      ['as' => 'admin_page_delete', 'uses' => 'PageController@delete']);
    });
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
