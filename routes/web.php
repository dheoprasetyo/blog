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


Route::get('/', function () {
    return view('blog.index');
});
 
Route::get('/blog/show', function(){
  return view('blog.show');
});
Route::get('/',[
	'uses' => 'BlogController@index',
	'as' => 'blog',
]);
Route::get('/blog/{posts}',[
	'uses' => 'BlogController@show',
	'as' => 'blog.show',
]);
Route::get('/author/{author}',[
	'uses' => 'BlogController@author',
	'as' => 'author'
]);
Route::get('/category/{category}',[
	'uses' => 'BlogController@category',
	'as' => 'category'
]);

Auth::routes();

Route::get('/home', 'Backend\HomeController@index')->name('home');
Route::resource('/backend/blog', 'Backend\BlogController',['as'=>'backend']);