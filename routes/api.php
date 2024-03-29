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

Route::post('', ['uses'=>'ApplicationController@create']);
Route::post('update',['uses'=>'ApplicationController@update']);

Route::get('leaderboard/{leaderboard_id}', ['uses'=>'LeaderboardController@getLeaderboardScores']);
Route::post('leaderboard/{leaderboard_id}/score', ['uses'=>'LeaderboardController@updateScore']);
Route::post('leaderboard', ['uses'=>'LeaderboardController@create']);

Route::post('request/queue/{id}/delete', ['uses'=>'QueueRequestController@delete']);
Route::get('request/queue/{id}', ['uses'=>'QueueRequestController@get']);
Route::post('request/queue', ['uses'=>'QueueRequestController@create']);

Route::get('country/list',['uses'=>'CountryController@index']);

Route::post('user/login',['uses'=>'AppUserController@login']);
Route::post('user',['uses'=>'AppUserController@create']);
Route::post('user/social/facebook-login',['uses'=>'AppUserController@loginWithFacebook']);
Route::post('user/update',['uses'=>'AppUserController@update']);
Route::get('user/me',['uses'=>'AppUserController@getMe']);

Route::get('user/transactions',['uses'=>'UserTransactionController@getUserTransactions']);
//Route::get('application/transactions',['uses'=>'UserTransactionController@getApplicatonTransactions']);
Route::post('transactions/update-status',['uses'=>'UserTransactionController@updateStatus']);
Route::post('user/transactions',['uses'=>'UserTransactionController@postTransaction']);