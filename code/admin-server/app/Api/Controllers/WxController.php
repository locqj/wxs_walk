<?php

namespace App\Api\Controllers;
use App\Api\Traits\Responder;
use DB;

include_once "wxBizDataCrypt.php";

class WxController extends Controller
{
    public function getSessionKey() {
    $appid = 'wxf76e84aadd80de0c';
    $appsecret = '68c6bdc3f6de8868d870615b0a9dd276';
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$_GET['code'].'&grant_type=authorization_code';
    $content = file_get_contents($url);
    //$content = json_decode($content);
    return $content;

    }

    public function decrypt() {
        $appid = 'wxf76e84aadd80de0c';
        $encryptedData = $_GET['encryptedData'];
        $iv = $_GET['iv'];
        $sessionKey = "JP1l68irXDG+sRZm+laCOg==";
        //return strlen($sessionKey);
        $pc = new \WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        return $errCode;
        if ($errCode == 0) {
            return response()->json($data);
        } else {
            return response()->json($data);
        }
    }
}
