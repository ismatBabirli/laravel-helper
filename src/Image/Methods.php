<?php
/**
 * Created by PhpStorm.
 * User: ismat
 * Date: 10/25/18
 * Time: 12:28 AM
 */

namespace Ismat\Helper\Image;


use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Methods
{

    public static function createPicture($picture, $x, $y, $extension, $type, $base64 = true)
    {
        if ($base64) {
            $explode = explode(',', $picture);

            $extension = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
        }


        $image = Image::make($picture);
        $image->resize($y, $x);
        $p_name = config("iConfig.image_output_folder") . $type . "/p_" . str_random(10) . strtotime(Carbon::now()) . '.' . $extension;
        if (!is_dir(config("iConfig.image_output_folder") . $type))
            self::createDir(config("iConfig.image_output_folder") . $type . "/");
        $image->save(public_path() . $p_name);
        return $p_name;
    }

    private static function createDir($path)
    {
        mkdir(public_path($path), 0765, true);
        return true;
    }

    public static function getUserData($uid)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(config("iConfig.admin_config_json_path"));

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $auth = $firebase->getAuth();
        return $auth->getUser($uid);
    }

    public static function checkLastLoginDate($lastLogin)
    {
        //Check User last login if user logged now
        return ($lastLogin->setTimezone(Carbon::now()->getTimezone()) > Carbon::now()->subSeconds(config("iConfig.login_check_time_duration")));
    }


}
