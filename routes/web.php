<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/tasks', 'TaskController@list')->name('tasks');
        Route::post('/task/save/{task?}', 'TaskController@save')->name('task.save');
        Route::get('/task/{task}', 'TaskController@task')->name('task');
        Route::post('/task/conclude/{task}', 'TaskController@conclude')->name('task.conclude');
        Route::post('/task/archive/{task}', 'TaskController@archive')->name('task.archive');
    });

    Route::get('{any}', function () {
        return view('app');
    })->where('any', '.*');
});
