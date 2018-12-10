<?php
/**
 * Created by PhpStorm.
 * User: ismat
 * Date: 10/25/18
 * Time: 12:28 AM
 */

namespace Ismat\Helper\Image;


use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Images;


class Image
{


    public static function create($picture, $x, $y, $extension, $type, $base64 = false)
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


        $image = Images::make($picture);
        if (!is_null($x) and !is_null($y)) {
            $image->resize($y, $x);
        }
        $p_name = config("iConfig.image_output_folder") . $type . "/p_" . str_random(10) . strtotime(Carbon::now()) . '.' . $extension;
        if (!is_dir(public_path(config("iConfig.image_output_folder") . $type)))
            self::createDir(config("iConfig.image_output_folder") . $type . "/");
        $image->save(public_path($p_name));
        return $p_name;
    }

    private static function createDir($path)
    {
        mkdir(public_path($path), 0765, true);
        return true;
    }


}
