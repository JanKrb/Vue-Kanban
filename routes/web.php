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

Route::get('/home', function () {
    return redirect(route('boards.index'));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('boards', 'App\Http\Controllers\BoardController@index')->name('boards.index');
    Route::get('board/{id}', 'App\Http\Controllers\TaskController@index')->name('tasks.index');
    Route::post('board/{id}/tasks', 'App\Http\Controllers\TaskController@store')->name('tasks.store');
    Route::put('board/{id}/tasks/sync', 'App\Http\Controllers\TaskController@sync')->name('tasks.sync');
    Route::put('board/{id}/task/{task}', 'App\Http\Controllers\TaskController@update')->name('tasks.update');

    Route::post('board/{id}/statuses', 'App\Http\Controllers\StatusController@store')->name('statuses.store');
    Route::put('board/{id}/statuses', 'App\Http\Controllers\StatusController@update')->name('statuses.update');
    Route::put('board/{id}/statuses/sync', 'App\Http\Controllers\StatusController@sync')->name('statuses.sync');
});
