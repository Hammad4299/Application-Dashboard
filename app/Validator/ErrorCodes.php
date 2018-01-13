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
 * @apiError (Code) {Integer} 12 FBID_NOT_PERMITTED
 * @apiError (Code) {Integer} 13 FB_AUTH_NOT_AVAILABLE
 * @apiError (Code) {Integer} 14 FB_AUTH_ERROR
 * @apiError (Code) {Integer} 15 FB_API_ERROR
 * @apiError (Code) {Integer} 16 URL_REQUIRED
 * @apiError (Code) {Integer} 17 METHOD_REQUIRED
 * @apiError (Code) {Integer} 18 INVALID_URL
 * @apiError (Code) {Integer} 19 INVALID_REFERRAL_CODE
 * @apiError (Code) {Integer} 20 APPLICATION_MAPPED_NAME_REQUIRED
 * @apiError (Code) {Integer} 21 APPLICATION_USERID_REQUIRED
 * @apiError (Code) {Integer} 22 ACCOUNT_BLOCKED
 * @apiError (Code) {Integer} 23 DEVICE_NAME_MISSING
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
    public static $FBID_NOT_PERMITTED = 12;
    public static $FB_AUTH_NOT_AVAILABLE = 13;
    public static $FB_AUTH_ERROR = 14;
    public static $FB_API_ERROR = 15;
    public static $URL_REQUIRED = 16;
    public static $METHOD_REQUIRED = 17;
    public static $INVALID_URL = 18;
    public static $INVALID_REFERRAL_CODE = 19;
    public static $APPLICATION_MAPPED_NAME_REQUIRED = 20;
    public static $APPLICATION_USERID_REQUIRED = 21;
    public static $ACCOUNT_BLOCKED = 22;
    const DEVICE_NAME_MISSING = 23;
}