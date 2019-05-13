<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/')
    ->group(function () {
        // GET | list items
        Route::get('items', ['uses' => 'ItemController@items'])->name('items');
        // GET | show item
        Route::get('item/{id}', ['uses' => 'ItemController@item'])->name('item');
        // POST | create item
        Route::post('create', ['uses' => 'ItemController@create'])->name('create');
        // PUT | update item
        Route::put('update/{id}', ['uses' => 'ItemController@update'])->name('update');
        // DELETE | delete sent
        Route::delete('delete/{id}', ['uses' => 'ItemController@delete'])->name('delete');
    });
