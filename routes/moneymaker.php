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

use Illuminate\Support\Facades\Route;

Route::put('/application/{application_id}', 'ApplicationController@update')
    ->name('application.update');
Route::get('/application/{application_id}/edit', 'ApplicationController@edit')
    ->name('application.edit');
Route::delete('/application/{application_id}/delete', 'ApplicationController@destroy')
    ->name('application.destroy');
Route::get('/application/{application_id}/show', 'ApplicationController@show')
    ->name('application.show');
Route::get('/application/{application_id}/users', function(){})->name('application.users');
Route::get('/application/{application_id}/leaderboards', function(){})->name('application.leaderboards');