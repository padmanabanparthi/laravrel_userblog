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

Route::get('/', 'PagesController@index');
Route::get('/blog', 'PostController@index');
Route::get('/blog/{id}/{title}', ['uses' =>'PostController@single_blog']);
Route::get('/notes', 'PagesController@notes');

// ============== authendicated routes =====================/
Auth::routes();

Route::prefix('members')->middleware(['auth','can:isUser'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@profile');
    Route::get('/profile/edit', 'HomeController@edit');
    Route::post('/profile/update', 'HomeController@update');
    Route::get('/my-posts', 'PostController@posts_by_member');
    Route::resource('/blog', 'PostController');
});


Route::prefix('admin')->middleware(['auth','can:isAdmin'])->group(function () {
    Route::get('/dashboard', 'admin\DashboardController@index')->name('dashboard');
    Route::resource('/users', 'admin\MemberController');
    Route::resource('/posts', 'admin\PostController');
    Route::get('/posts-by-user/{id}', ['uses' =>'admin\PostController@index']);
});
