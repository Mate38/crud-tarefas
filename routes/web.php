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

        Route::prefix('task')->name('task.')->group(function () {
            Route::post('/list', 'TaskController@list')->name('list');
            Route::post('/save/{task?}', 'TaskController@save')->name('save');
            Route::post('/conclude/{task}', 'TaskController@conclude')->name('conclude');
            Route::post('/archive/{task}', 'TaskController@archive')->name('archive');
            
            Route::get('/{task}', 'TaskController@task')->name('task');
        });

        Route::prefix('tag')->name('tag.')->group(function () {
            Route::post('/list', 'TagController@list')->name('list');
            Route::post('/save/{tag?}', 'TagController@save')->name('save');
            Route::get('/options', 'TagController@options')->name('options');
            Route::post('/delete/{tag}', 'TagController@delete')->name('delete');

            Route::get('/{tag}', 'TagController@tag')->name('tag');
        });

    });

    Route::get('{any}', function () {
        return view('app');
    })->where('any', '.*');
});
