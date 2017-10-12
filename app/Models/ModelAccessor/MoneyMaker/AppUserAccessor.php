<?php

namespace App\Models\ModelAccessor\MoneyMaker;
use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\AppUser;
use App\Validator\ErrorCodes;

class AppUserAccessor extends \App\Models\ModelAccessor\AppUserAccessor
{
    protected function getUserOnLoginAuthentication($user_id){
        $resp = parent::getUserOnLoginAuthentication($user_id);
        if($resp->getStatus()) {
            /**
             * @var AppUser $resp->data
             */
            $resp->data->api_token = $this->createNewToken();
            $resp->data->save();
        }
        return $resp;
    }

    protected function createOrUpdate(AppResponse $resp, AppUser $appUser, $data, $isEdit)
    {
        $referralCodeLength = Helper::getWithDefault($data, 'referral_code_length', 6);
        $referralCode = Helper::getWithDefault($data,'referral_code',null);
        $reward_pending_referrals = Helper::getWithDefault($data,'reward_pending_referrals',null);
        if($isEdit){
            $reward_pending_referrals = $reward_pending_referrals === null ? $appUser->reward_pending_referrals : $reward_pending_referrals;
        } else {
            $appUser->total_referrals = 0;
            $appUser->referral_code = $this->generateUniqueReferralCode($appUser->application_id,$referralCodeLength);
        }

        $referredUser = null;
        if($referralCode!==null && !$isEdit){
            $referredUser = $this->getUserByReferralCode($referralCode,$appUser->application_id);
            if($referredUser===null){
                $resp->addError('referral_code','Invalid referral code', ErrorCodes::$INVALID_REFERRAL_CODE);
            }
        }

        if($resp->getStatus()){
            if($reward_pending_referrals===null)
                $reward_pending_referrals = 0;

            $appUser->reward_pending_referrals = $reward_pending_referrals;
            parent::createOrUpdate($resp, $appUser, $isEdit,$data); // TODO: Change the autogenerated stub

            if($resp->getStatus() && $referredUser!==null && !$isEdit){
                $referredUser->total_referrals++;
                $referredUser->reward_pending_referrals++;
                $referredUser->save();
            }
        }
    }
}