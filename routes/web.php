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

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::resource('/students', 'StudentsController');
Route::resource('/stdClass', 'StdClassController');
Route::resource('/fees', 'FeesController');

Route::post('/dashboard/show', 'DashboardController@show');
Route::put('/changefees', 'StdClassController@fees');
Route::post('/searchStd', 'StudentsController@search');
Route::get('/takes/{take}','FeesController@take');
Route::get('/paid','FeesController@paid');

// Route::get('/promote/{id}', 'StdClassController@promote');
// Route::get('/promoteStds','StdClassController@stdPromoted');
