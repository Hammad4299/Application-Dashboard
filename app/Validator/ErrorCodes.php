<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 4/11/2017
 * Time: 2:43 PM
 */

namespace App\Validator;

/**
 * @api {None} api-error-codes ErrorCodes
 * @apiGroup Error Codes
 * @apiError (Code) {Integer} 1 APPLICATION_NAME_REQUIRED
 * @apiError (Code) {Integer} 2 USERNAME_REQUIRED
 * @apiError (Code) {Integer} 3 LEADERBOARD_NAME_REQUIRED
 * @apiError (Code) {Integer} 4 SCORE_VALUE_REQUIRED_REQUIRED
 * @apiError (Code) {Integer} 5 USER_LEADERBOARD_ACCESS_UNAUTHORIZED
 * @apiError (Code) {Integer} 6 LEADERBOARD_NOT_FOUND
 * @apiError (Code) {Integer} 7 PASSWORD_REQUIRED
 * @apiError (Code) {Integer} 8 USERNAME_EXISTS
 * @apiError (Code) {Integer} 9 INCORRECT_LOGIN_CREDENTIALS
 * @apiError (Code) {Integer} 10 EMAIL_EXISTS
 * @apiError (Code) {Integer} 11 AMOUNT_REQUIRED
 */
class ErrorCodes
{
    public static $APPLICATION_NAME_REQUIRED = 1;
    public static $USERNAME_REQUIRED = 2;
    public static $LEADERBOARD_NAME_REQUIRED = 3;
    public static $SCORE_VALUE_REQUIRED_REQUIRED = 4;
    public static $USER_LEADERBOARD_ACCESS_UNAUTHORIZED = 5;
    public static $LEADERBOARD_NOT_FOUND = 6;
    public static $PASSWORD_REQUIRED = 7;
    public static $USERNAME_EXISTS = 8;
    public static $INCORRECT_LOGIN_CREDENTIALS = 9;
    public static $EMAIL_EXISTS = 10;
    public static $AMOUNT_REQUIRED = 11;
}