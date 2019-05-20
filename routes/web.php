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
    return view('welcome');
});

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/about', function () {
//        echo Auth::user()->usertype."<br>";
       
//        if (Gate::allows('isUser')) {
//             echo "user can view this page";
//         }

//         if (Gate::allows('isAdmin')) {
//             echo "admin also can view this page";
//         }
//     });
    
//     Route::get('/service', function () {
//         return "service page";
//     });
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
