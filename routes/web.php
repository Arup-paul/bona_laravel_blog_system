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
// })->name('home');



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//frontend route
//Admin route group
Route::group([ 'namespace' => 'frontend'], function () {
   Route::get('post/{slug}','PostController@details')->name('post.details');
   Route::get('/posts','PostController@allpost')->name('post.all');
   Route::get('category/{slug}','PostController@postByCategory')->name('category.posts');
   Route::get('tag/{slug}','PostController@postByTag')->name('tag.posts');

   Route::get('/search','SearchController@search')->name('search');
   
   Route::get('/profile/{username}','AuthorController@profile')->name('author.profile');





});

//subscriber route
Route::post('subscriber','SubscriberController@store')->name('subscriber.store');

// post route group

Route::group(['middleware'=> ['auth']],function(){
   Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
   Route::post('/comment/{post}','frontend\CommentsController@store')->name('comment.store');
});


//Admin route group
Route::group(['as'=> 'admin.','prefix' => 'admin', 'namespace' => 'Admin','middleware' => ['auth','admin']], function () {

Route::get('/dashboard','DashboardController@index')->name('dashboard');
Route::get('/settings','SettingsController@index')->name('settings');
Route::put('/profile-update','SettingsController@updateProfile')->name('profile.update');

Route::put('/password-update','SettingsController@updatePassword')->name('password.update');

Route::get('favorite','FavoriteController@index')->name('favorite.index');

Route::resource('tag', 'TagController');
Route::resource('category', 'CategoryController');
Route::resource('post', 'PostController');


Route::get( '/pending/post', 'PostController@pending' )->name( 'post.pending' );
Route::put('/post/{id}/approve','PostController@approval')->name('post.approve');

Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
Route::delete('/subscriber/{id}','SubscriberController@destroy')->name('subscriber.destroy');

//comment route

Route::get('/comments','CommentController@index')->name('comment.index');
Route::delete('/commentsDestroy/{id}','CommentController@destroy')->name('comment.destroy');


//Author controller

Route::get('authors','AuthorController@index')->name('author.index');
Route::delete('authors/{id}','AuthorController@destroy')->name('author.destroy');


});

//Author Route Group
Route::group(['as'=> 'author.','prefix' => 'author', 'namespace' => 'Author','middleware' => ['auth','author']], function () {


Route::get('/settings','SettingsController@index')->name('settings');
Route::put('/profile-update','SettingsController@updateProfile')->name('profile.update');
Route::put('/password-update','SettingsController@updatePassword')->name('password.update');

Route::get( '/dashboard', 'DashboardController@index' )->name( 'dashboard' );

Route::resource( 'post', 'PostController' );

Route::get( 'favorite', 'FavoriteController@index' )->name( 'favorite.index' );

//comment route
Route::get( '/comments', 'CommentController@index' )->name( 'comment.index' );
Route::delete( '/commentsDestroy/{id}', 'CommentController@destroy' )->name( 'comment.destroy' );

});



View::composer('layouts.frontend.partials._footer',function($view){
   $categories = App\Model\Category::all();
   $view->with('categories',$categories);
});
