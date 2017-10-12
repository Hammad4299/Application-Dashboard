<?php
namespace App\Http\Controllers\Api\MoneyMaker;

use App\Models\ModelAccessor\MoneyMaker\AppUserAccessor;


/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class AppUserController extends \App\Http\Controllers\Api\AppUserController
{
    public function __construct(AppUserAccessor $accessor)
    {
        parent::__construct($accessor);
    }

    /**
     * @api {POST} moneymaker/user/login Login User
     * @apiDescription Login user and get user Api key. <b>User scores (with leaderboard) will also present in returned object. Previous Api Key will be invalidated</b>
     * @apiGroup AppUser (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse AppUserLoginCommon
     * @apiUse queuedSupport
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/

    /**
     * @api {POST} moneymaker/user Register User
     * @apiGroup AppUser (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse AppUserRegisterCommon
     * @apiUse queuedSupport
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @apiParam (form) {String} [referral_code] Referral code used to signup
     * @apiParam (form) {Integer} [referral_code_length=6] Length of referral code to generate for this user
     **/


    /**
     * @api {POST} moneymaker/user/social/facebook-login Login/Register Using Facebook
     * @apiGroup AppUser (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiParam (form) {String} [referral_code] Referral code used to signup
     * @apiParam (form) {Integer} [referral_code_length=6] Length of referral code to generate for this user
     * @apiUse AppUserSocialLoginCommon
     * @apiUse queuedSupport
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/


    /**
     * @api {POST} moneymaker/user/update Update user
     * @apiGroup AppUser (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiParam (form) {Integer} [reward_pending_referrals] New value if any given.
     * @apiUse AppUserEditCommon
     * @apiUse authUser
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     **/


    /**
     * @api {GET} moneymaker/user/me Get Me
     * @apiGroup AppUser (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse AppUserGetCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     **/

}