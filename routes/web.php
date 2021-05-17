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
Auth::routes();

Route::get('/home', function () {
    return redirect()->route('tasks.index');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('tasks', 'App\Http\Controllers\TaskController@index')->name('tasks.index');
    Route::post('tasks', 'App\Http\Controllers\TaskController@store')->name('tasks.store');
    Route::put('tasks/sync', 'App\Http\Controllers\TaskController@sync')->name('tasks.sync');
    Route::put('tasks/{task}', 'App\Http\Controllers\TaskController@update')->name('tasks.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('statuses', 'App\Http\Controllers\StatusController@store')->name('statuses.store');
    Route::put('statuses', 'App\Http\Controllers\StatusController@update')->name('statuses.update');
    Route::put('statuses/sync', 'App\Http\Controllers\StatusController@sync')->name('statuses.sync');
});
