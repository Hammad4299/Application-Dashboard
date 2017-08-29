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
Route::get('/application/{application_id}/users', 'AppUserController@show')
    ->name('application.users');
Route::post('/application/{application_id}/user/{app_user_id}/changeState', 'AppUserController@changeState')
    ->name('application.users.changeState');
Route::delete('/application/{application_id}/user/{app_user_id}/delete', 'AppUserController@destroy')
    ->name('application.users.delete');

Route::get('/application/{application_id}/transactions/pending', 'AppUserTransactionsController@showPending')
    ->name('application.transactions.pending');
Route::get('/application/{application_id}/transactions/accepted', 'AppUserTransactionsController@showAccepted')
    ->name('application.transactions.accepted');
Route::get('/application/{application_id}/transactions/rejected', 'AppUserTransactionsController@showRejected')
    ->name('application.transactions.rejected');

Route::post('/application/{application_id}/transaction/{transaction_id}/updateStatus', 'AppUserTransactionsController@updateStatus')
    ->name('application.transactions.updateStatus');
