<?php
/**
 * Created by PhpStorm.
 * User: ismat
 * Date: 10/25/18
 * Time: 12:09 PM
 */

namespace Ismat\Helper\Firebase;

use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Auth
{


    public static function getUserData($uid)
    {
        try {
            $serviceAccount = ServiceAccount::fromJsonFile(config("iConfig.admin_config_json_path"));

            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();
            $auth = $firebase->getAuth();
            $user = $auth->getUser($uid);
            $user->disabled = !self::checkLastLoginDate($user->metadata->lastLoginAt);
            return $user;

        } catch (\Exception $exception) {
            return null;
        }
    }

    private static function checkLastLoginDate($lastLogin)
    {
        //Check User last login if user logged now
        return ($lastLogin->setTimezone(Carbon::now()->getTimezone()) > Carbon::now()->subSeconds(config("iConfig.login_check_time_duration")));
    }

}
