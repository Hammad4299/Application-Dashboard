<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 4/11/2017
 * Time: 2:43 PM
 */

namespace App\Validator;


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
}