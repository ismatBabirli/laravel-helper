<?php
/**
 * Created by PhpStorm.
 * User: ismat
 * Date: 10/25/18
 * Time: 12:11 PM
 */

namespace Ismat\Helper\Useful;


class Useful
{
    public static function createResponse($code = 1, $message = "OK", $content = [], $status_code = 200)
    {

              $response = [
            'responseCode' => $code,
            "responseMessage" => $message,
//            "responseContent" => (isset($content) and !is_null($content)) ? $content : []
        ];
        if (isset($content) and $content != [])
            $response = Arr::add($response, "responseContent", $content);
        return response($response, $status_code);
    }


}
