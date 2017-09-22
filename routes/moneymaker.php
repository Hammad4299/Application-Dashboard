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
$moneyMaker = \App\Applications\MoneyMakerApplication::getInstance();
$moneyMakerRouteNamePrefix = $moneyMaker->getRouteNamePrefix();

Route::put('/application/{application_id}', 'ApplicationController@update')
    ->name($moneyMakerRouteNamePrefix.'application.update');
Route::get('/application/{application_id}/edit', 'ApplicationController@edit')
    ->name($moneyMakerRouteNamePrefix.'application.edit');
//Route::delete('/application/{application_id}/delete', 'ApplicationController@destroy')
//    ->name($moneyMakerRouteNamePrefix.'application.destroy');
Route::get('/application/{application_id}/show', 'ApplicationController@show')
    ->name($moneyMakerRouteNamePrefix.'application.show');
Route::get('/application/{application_id}/users', 'AppUserController@show')
    ->name($moneyMakerRouteNamePrefix.'application.users');
Route::post('/application/{application_id}/user/{app_user_id}/changeState', 'AppUserController@changeState')
    ->name($moneyMakerRouteNamePrefix.'application.users.changeState');
Route::delete('/application/{application_id}/user/{app_user_id}/delete', 'AppUserController@destroy')
    ->name($moneyMakerRouteNamePrefix.'application.users.delete');

Route::get('/application/{application_id}/transactions/pending', 'AppUserTransactionsController@showPending')
    ->name($moneyMakerRouteNamePrefix.'application.transactions.pending');
Route::get('/application/{application_id}/transactions/accepted', 'AppUserTransactionsController@showAccepted')
    ->name($moneyMakerRouteNamePrefix.'application.transactions.accepted');
Route::get('/application/{application_id}/transactions/rejected', 'AppUserTransactionsController@showRejected')
    ->name($moneyMakerRouteNamePrefix.'application.transactions.rejected');

Route::post('/application/{application_id}/transaction/{transaction_id}/updateStatus', 'AppUserTransactionsController@updateStatus')
    ->name($moneyMakerRouteNamePrefix.'application.transactions.updateStatus');
