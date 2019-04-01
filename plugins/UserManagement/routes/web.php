<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:42 PM
 */

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





/*
 * User routes
 */
Route::group(['prefix' => 'users-management/users', 'as' => 'users-management.users'], function () {

    Route::resource('', 'UserController', [
        'names' => [
            'create' => '.create',
            'store' => '.store',
            'edit' => '.edit',
            'show' => '.show',
            'update' => '.update',
            'destroy' => '.destroy',
            'index' => '.index'
        ]
    ]);
});



          /**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/
