<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
/**
 * @apiDefine countryDef
 * @apiSuccess (Country) {Integer} id Id of country
 * @apiSuccess (Country) {String} name Name of country
 */

/**
 * @apiDefine applicationDef
 * @apiSuccess (Application) {String} name Name of application
 * @apiSuccess (Application) {String} api_token Application API Key
 * @apiSuccess (Application) {Integer} created_at Unix timestamp
 * @apiSuccess (Application) {Integer} modified_at Unix timestamp
 */

/**
 * @apiDefine responseDef
 * @apiSuccess (Response) {Boolean} status
 * @apiSuccess (Response) {T} data <b>Nullable</b>. Data of request
 * @apiSuccess (Response) {Dictionary(String)(ErrorDetail[])} errors <b>Nullable</b>. Dictionary of fields against their ErrorDetails
 * @apiSuccessExample Example
 * {status: true,data: null,errors: {
 *      first_name: [{message: "Message 1",code: -1},{message: "Message 2",code: -2}],
 *      email: [{message: "Email is required",code: -3},{message: "Email already in use",code: -4}]
 * }}
 */

/**
 * @apiDefine errorDetailDef
 * @apiSuccess (ErrorDetail) {String} message
 * @apiSuccess (ErrorDetail) {Integer} code ErrorCode. See <b>ErrorCodes</b> for details
 */

/**
 * @apiDefine transactionDef
 * @apiSuccess (UserTransaction) {Integer} id
 * @apiSuccess (UserTransaction) {Integer} application_id
 * @apiSuccess (UserTransaction) {Integer} app_user_id
 * @apiSuccess (UserTransaction) {Integer} amount
 * @apiSuccess (UserTransaction) {BigInteger} updated_at Unix Timestamp
 * @apiSuccess (UserTransaction) {Integer} status Status Code
 * @apiSuccess (UserTransaction) {String} status_str Status Value
 * @apiSuccess (UserTransaction) {BigInteger} request_time Unix Timestamp
 */

/**
 * @api {NONE} api-types/response Response(T)
 * @apiGroup Type Definitions
 * @apiUse responseDef
 */

/**
 * @api {NONE} api-types/application Application
 * @apiGroup Type Definitions
 * @apiUse applicationDef
 */

/**
 * @api {NONE} api-types/country Country
 * @apiGroup Type Definitions
 * @apiUse countryDef
 */

/**
 * @api {NONE} api-types/error-detail ErrorDetail
 * @apiGroup Type Definitions
 * @apiUse errorDetailDef
 */

/**
 * @api {NONE} api-types/user-transaction UserTransaction
 * @apiGroup Type Definitions
 * @apiUse transactionDef
 */

/**
 * @apiDefine successResponseWrapper Success Response Wrapper
 * @apiSuccess (Success 200) {JSON} ResponseBody This is actual response body received. Other Response parameters are part of <i>data</i> property of this JSON. <i>data</i> property can be null.
 * @apiSuccessExample {json} Success-Response:
    { errors: null, data: &lt;See description&gt;,status: true }
 */

/**
 * @apiDefine authApp
 * @apiHeader {String} Authorization For example <b>Bearer &lt;application_api_key&gt;</b>. <u>Do not enter &lt; and &gt;</u>
 */

/**
 * @apiDefine authUser
 * @apiHeader {String} Authorization For example <b>Bearer &lt;user_api_key&gt;</b>. <u>Do not enter &lt; and &gt;</u>
 */

/**
 * @apiDefine errorResponseWrapper Success Response Wrapper
 * @apiError (Error 200) {Object} error_object_sample <b>Part of ResponseBody <i>errors</i> property</b>. See sample.
 * @apiErrorExample {json} Error-Response:
{ errors: {
 *     first_name: [{message: "first error message for first_name",code: &lt;Refer Error Codes&gt;},{message: "2nd error message for first_name",code: &lt;Refer Error Codes&gt;}],
 *     last_name: [{message: "first error message for last_name",code: &lt;Refer Error Codes&gt;},{message: "2nd error message for last_name",code: &lt;Refer Error Codes&gt;}],
 * }, data: null,status: false }
 */

/**
 * @apiDefine errorUnauthorized Success Response Wrapper
 * @apiError (Error 401) {Response(Object)} Body
 * @apiErrorExample {json} Error-Response:
{ errors: {
 *     api_token: [{message: "Invalid or missing token",code: -1}]
 * }, data: null,status: false }
 */

/**
 * Class Controller
 * @package App\Http\Controllers
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
