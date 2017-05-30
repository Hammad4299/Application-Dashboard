<?php

namespace App\Http\Controllers;

/**
 * @apiDefine commonUserUpdateRegisterParams
 * @apiParam (form) {String} [email]
 * @apiParam (form) {String} [first_name]
 * @apiParam (form) {String} [last_name]
 * @apiParam (form) {Integer=0,1} [gender] 0=Female,1=Male
 * @apiParam (form) {String} [country] If not specified, then country will be set based on IP
 * @apiParam (form) {Json} [extra] Any optional properties
 */

/**
 * @apiDefine queuedSupport
 * @apiParam (form) {String} [queued_request_id] Json Array of queued request ids. <b>These will be executed in order and only when status of original request is true.</b>
 */

/**
 * @apiDefine appUserDef
 * @apiSuccess (AppUser) {Integer} id User id
 * @apiSuccess (AppUser) {Integer} application_id Application to which user belongs
 * @apiSuccess (AppUser) {String} api_token <b>Nullable</b>. User API key
 * @apiSuccess (AppUser) {String{..128}} username
 * @apiSuccess (AppUser) {String{..128}} email <b>Nullable</b>
 * @apiSuccess (AppUser) {String{..128}} first_name  <b>Nullable</b>
 * @apiSuccess (AppUser) {String{..128}} last_name  <b>Nullable</b>
 * @apiSuccess (AppUser) {String} gender_string
 * @apiSuccess (AppUser) {Integer=1,0} gender <b>Nullable</b>. 1=Male, 0=Female
 * @apiSuccess (AppUser) {String} country <b>Nullable</b>
 * @apiSuccess (AppUser) {Json} extra <b>Nullable</b>
 * @apiSuccess (AppUser) {Integer} created_at Unix Timestamp
 * @apiSuccess (AppUser) {AppUserScore[]} scores <b>Nullable</b>
 */

/**
 * @apiDefine countryDef
 * @apiSuccess (Country) {Integer} id Id of country
 * @apiSuccess (Country) {String} name Name of country
 */

/**
 * @apiDefine appLeaderboardDef
 * @apiSuccess (AppLeaderboard) {Integer} id Id of leaderboard
 * @apiSuccess (AppLeaderboard) {Integer} application_id Application to which it belongs
 * @apiSuccess (AppLeaderboard) {String} name Name of country
 * @apiSuccess (AppLeaderboard) {AppUserScore[]} scores <b>Nullable</b>
 */

/**
 * @apiDefine queuedRequestDef
 * @apiSuccess (AppLeaderboard) {Integer} id Id of leaderboard
 * @apiSuccess (AppLeaderboard) {Integer} application_id Application to which it belongs
 * @apiSuccess (AppLeaderboard) {String} response <b>Nullable</b>. Response received on execution
 */

/**
 * @apiDefine leaderboardScoreWithRankDef
 * @apiSuccess (LeaderboardScoreWithRank) {AppLeaderboard} board Leaderboard with scores (with rank) loaded
 * @apiSuccess (LeaderboardScoreWithRank) {AppUserScore} me <b>Nullable</b>. Score with rank of user defined by <b>app_user_id</b>
 */


/**
 * @apiDefine appUserScoreDef
 * @apiSuccess (AppUserScore) {Integer} id Id of user score
 * @apiSuccess (AppUserScore) {Integer} app_user_id User id to which this score belongs
 * @apiSuccess (AppUserScore) {Integer} application_id application id to which this score belongs
 * @apiSuccess (AppUserScore) {Integer} leaderboard_id Leaderboard id to which this score belongs
 * @apiSuccess (AppUserScore) {BigInteger} score Score value
 * @apiSuccess (AppUserScore) {Integer} modified_at Unix Timestamp
 * @apiSuccess (AppUserScore) {Integer} [rank] Rank of user in leaderboard
 * @apiSuccess (AppUserScore) {AppLeaderboard} leaderboard <b>Nullable</b>
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
 * @apiSuccess (UserTransaction) {Decimal} amount Total 19 digits with 4 decimal places supported
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
 * @api {NONE} api-types/leaderboard-scores-with-rank LeaderboardScoreWithRank
 * @apiGroup Type Definitions
 * @apiUse leaderboardScoreWithRankDef
 */

/**
 * @api {NONE} api-types/application Application
 * @apiGroup Type Definitions
 * @apiUse applicationDef
 */

/**
 * @api {NONE} api-types/queued-request QueuedRequest
 * @apiGroup Type Definitions
 * @apiUse queuedRequestDef
 */

/**
 * @api {NONE} api-types/app-user AppUser
 * @apiGroup Type Definitions
 * @apiUse appUserDef
 */

/**
 * @api {NONE} api-types/app-leaderboard AppLeaderboard
 * @apiGroup Type Definitions
 * @apiUse appLeaderboardDef
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
 * @api {NONE} api-types/app-user-score AppUserScore
 * @apiGroup Type Definitions
 * @apiUse appUserScoreDef
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
 * @apiDefine errorUnauthorized Success Response Wrapper
 * @apiError (Error 401) {Response(Object)} Body
 * @apiErrorExample {json} Error-Response:
{ errors: {
 *     api_token: [{message: "Invalid or missing token",code: -1}]
 * }, data: null,status: false }
 */