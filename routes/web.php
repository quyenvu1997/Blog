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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('admin')->group(function(){
	Auth::routes();
	Route::middleware(['auth'])->group(function(){
		Route::get('/dashboard', 'HomeController@dashboard');
		Route::get('/listposts','PostController@getdata')->name('posts');
		Route::get('/listcategories','CategoryController@getdata')->name('categories');
		Route::get('/listtags','TagController@getdata')->name('tags');
		Route::post('/posts/update/{id}','PostController@update');
		Route::resource('/posts','PostController');
		Route::resource('/tags','TagController');
		Route::post('/categories/update/{id}','CategoryController@update');
		Route::resource('/categories','CategoryController');
	});
});
Route::prefix('user')->group(function(){
	Route::get('/home','HomeController@index');
	Route::get('/search','HomeController@search');
	Route::get('/contact','HomeController@contact');
	Route::get('/posts/{slug}','HomeController@postshow');
	Route::get('/categories/{slug}','HomeController@categoryshow');
	Route::get('/userpost/{name}','HomeController@userpostshow');
	Route::get('/tags/{slug}','HomeController@tagshow');
});