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


Route::get('leaderboard/{leaderboard_id}', ['uses'=>'LeaderboardController@getLeaderboardScores']);
Route::post('leaderboard/{leaderboard_id}/score', ['uses'=>'LeaderboardController@updateScore']);
Route::post('leaderboard', ['uses'=>'LeaderboardController@create']);


Route::post('user/login',['uses'=>'AppUserController@login']);
Route::post('user',['uses'=>'AppUserController@create']);
Route::post('user/social/facebook-login',['uses'=>'AppUserController@loginWithFacebook']);
Route::post('user/update',['uses'=>'AppUserController@update']);
Route::get('user/me',['uses'=>'AppUserController@getMe']);

Route::get('user/transactions',['uses'=>'UserTransactionController@getUserTransactions']);
Route::post('transactions/update-status',['uses'=>'UserTransactionController@updateStatus']);
Route::post('user/transactions',['uses'=>'UserTransactionController@postTransaction']);