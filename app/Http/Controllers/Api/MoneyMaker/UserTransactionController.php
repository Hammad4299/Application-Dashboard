<?php
namespace App\Http\Controllers\Api\MoneyMaker;

use App\Models\ModelAccessor\MoneyMaker\AppUserTransactionAccessor;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class UserTransactionController extends \App\Http\Controllers\Api\UserTransactionController
{
    protected $accessor;
    public function __construct(AppUserTransactionAccessor $appUserTransactionAccessor)
    {
        parent::__construct($appUserTransactionAccessor);
    }

    /**
     * @api {POST} moneymaker/transactions/update-status Update Transaction Status
     * @apiGroup UserTransaction (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse UserTransactionUpdateCommon
     * @apiUse authApp
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     **/

    /**
     * @api {GET} moneymaker/user/transactions Get User Transactions
     * @apiGroup UserTransaction (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse UserTransactionUserGetCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     **/

    /**
     * @api {POST} moneymaker/user/transactions Create Transaction
     * @apiGroup UserTransaction (MoneyMaker)
     * @apiVersion 0.2.0
     * @apiParam (form) {Integer} [leaderboard_id] <b>This is atomic</b>. Leaderboard score to update.
     * @apiParam (form) {Integer} [score] <b>This is atomic</b>. New score value.
     * @apiUse UserTransactionCreateCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @apiUse queuedSupport
     **/
}