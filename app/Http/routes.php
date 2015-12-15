<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// index
Route::get('/', ['as' => 'root', 'uses' => 'SiteController@index']);
Route::get('/about', ['as' => 'root', 'uses' => 'PageController@about']);
Route::get('/page/{pagination}', ['as' => 'root', 'uses' => 'PageController@pagination']);
Route::get('/archives', ['as' => 'root', 'uses' => 'PageController@archives']);
Route::get('/tag/{tagName}', ['as' => 'root', 'uses' => 'PageController@tags']);
Route::get('/post/{slug}', ['as' => 'root', 'uses' => 'PostController@post']);
Route::get('/search', ['as' => 'root', 'uses' => 'PageController@search']);
Route::controller('posts', 'PostController');
