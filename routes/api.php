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

Route::post('application', ['uses'=>'ApplicationController@create']);
Route::post('application/update',['uses'=>'ApplicationController@update']);

Route::get('application/leaderboard/{leaderboard_id}', ['uses'=>'LeaderboardController@getLeaderboardScores']);
Route::post('application/leaderboard/{leaderboard_id}/score', ['uses'=>'LeaderboardController@updateScore']);
Route::post('application/leaderboard', ['uses'=>'LeaderboardController@create']);

Route::post('application/request/queue/{id}/delete', ['uses'=>'QueueRequestController@delete']);
Route::get('application/request/queue/{id}', ['uses'=>'QueueRequestController@get']);
Route::post('application/request/queue', ['uses'=>'QueueRequestController@create']);

Route::get('country/list',['uses'=>'CountryController@index']);

Route::post('application/user/login',['uses'=>'AppUserController@login']);
Route::post('application/user',['uses'=>'AppUserController@create']);
Route::post('application/user/social/facebook-login',['uses'=>'AppUserController@create']);
Route::post('application/user/update',['uses'=>'AppUserController@update']);
Route::get('application/user/me',['uses'=>'AppUserController@getMe']);

Route::get('application/user/transactions',['uses'=>'UserTransactionController@getUserTransactions']);
Route::get('application/transactions',['uses'=>'UserTransactionController@getApplicatonTransactions']);
Route::post('application/transactions/update-status',['uses'=>'UserTransactionController@updateStatus']);
Route::post('application/user/transactions',['uses'=>'UserTransactionController@postTransaction']);