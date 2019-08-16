<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/* ================== Homepage + Admin Routes ================== */

require __DIR__.'/admin_routes.php';




Route::get('/', 'TodoListController@index');
Route::post('/to-do-store', 'TodoListController@store');
Route::get('/status/{status}/{id}', 'TodoListController@status');
Route::post('/todo-order', 'TodoListController@todoOrder');


    