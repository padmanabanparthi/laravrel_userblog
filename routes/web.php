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
Route::get('/notes', function () {
    return view('notes');
});
Route::resource('/posts', 'PostController');
Route::get('/users', 'admin\MemberController@index');

// ============== authendicated routes =====================/
Auth::routes();

Route::prefix('members')->middleware(['auth','can:isUser'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});


Route::prefix('admin')->middleware(['auth','can:isAdmin'])->group(function () {
    Route::get('/dashboard', 'admin\DashboardController@index')->name('dashboard');
    Route::resource('/users', 'admin\MemberController');
    Route::resource('/posts', 'admin\PostController');
    Route::get('/posts-by-user/{id}', ['uses' =>'admin\PostController@index']);
});
