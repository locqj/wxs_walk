<?php

namespace App\Api\Controllers;
use App\Api\Traits\Responder;
use DB;
use Session;
use Illuminate\Http\Request;
use App\ClientUsers;
use App\TimeLog;
use App\RankingList;
include_once "wxBizDataCrypt.php";
class WxController extends Controller
{
    public function getSessionKey(Request $request) {
        $appid = 'wxf76e84aadd80de0c';
        $appsecret = '68c6bdc3f6de8868d870615b0a9dd276';
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$_GET['code'].'&grant_type=authorization_code';
        $content = file_get_contents($url);
        $content = json_decode($content);
        $openid = $content->openid;
        $session_key = $content->session_key;
        return response()->json(compact('openid', 'session_key'));
    }

    public function decrypt(Request $request) {
        $ranking_list = new RankingList;
        $client_users = new ClientUsers;
        $appid = 'wxf76e84aadd80de0c';
        $encryptedData = $request->get('encryptedData');
        $iv = $request->get('iv');
        $nickname = $request->get('nickname');
        $head_img = $request->get('head_img');
        $target_step = $request->get('target_step');
        $openid = $request->get('openid');
        $pc = new \WXBizDataCrypt($appid, $request->get('session'));
        $errCode = $pc->decryptData($encryptedData, $iv, $data);

        if ($errCode == 0) {
            $stepinfo = json_decode($data);
            $now_step = $stepinfo->stepInfoList[30]->step; //当天步数
            $nearly_30th = array_sum(array_column($stepinfo->stepInfoList,'step')); //近三十天步数
            $res = $this->clientInit($openid, $head_img, $nickname, $now_step, $nearly_30th, $target_step); //保存数据

            if ($res == 1) {
                $data = json_decode($data);
                $data->userinfo = $client_users->cGet($openid);
                $data->step_day = $ranking_list->rGetRankByDay();
                $data->step_month = $ranking_list->rGetRankByMonth();
                $data->change_goods = $this->getGoods('hzx0');
                $data = json_encode($data);
                return response()->json($data);
            }
        } else {
            // return response()->json($data);
        }
    }
    /**
     * [clientInit 保存数据]
     * @param  [type] $openid      [description]
     * @param  [type] $head_img    [description]
     * @param  [type] $nickname    [description]
     * @param  [type] $now_step    [description]
     * @param  [type] $nearly_30th [description]
     * @return [type]              [description]
     */
    public function clientInit($openid, $head_img, $nickname, $now_step, $nearly_30th, $target_step) {
        $client_users = new ClientUsers;
        $time_log = new TimeLog;
        $ranking_list = new RankingList;
        $dist = DB::table('client_users')->where('openid', $openid)->exists();
        // 判断用户是否存在
        if (!$dist) {
            $client_users->cInsert($openid, $now_step, $head_img, $nickname);
            $time_log->tInsert($openid, $now_step);
            $ranking_list->rInsert($openid, $now_step, $nearly_30th);
            return 1;
        } else {
            $log_step = $time_log->tGet($openid);
            $ranging_exist = $ranking_list->rGet($openid);
            // 判断当天步数log是否存在，存在就减去上一次log的步数 得到增加的步数，不存在说明当天第一次打开小程序
            if ($log_step && $ranging_exist) {
                $ranking_list->rUpdate($openid, $now_step, $nearly_30th);
                $step = $now_step - $log_step->step;
                if ($step != 0) {
                    $time_log->tUpdate($openid, $now_step);
                }
            } else {
                $time_log->tInsert($openid, $now_step);
                $ranking_list->rInsert($openid, $now_step, $nearly_30th);
                $step = $now_step;
            }
            // 当天步数达标就增加能量
            if ($now_step > $target_step) {
                $client_users->cUpdateStep($openid, $step, $nickname, $head_img);
                $client_users->cUpdatePower($openid, $this->getPowerNum($target_step));
            } else {
                $client_users->cUpdateStep($openid, $step, $nickname, $head_img);
            }
            return 1;
        }
    }

    public function getPowerNum($target_step) {
        switch ($target_step) {
            case '8000':
                return 1;
                break;
            case '12000':
                return 2;
                break;
            default:
                return 3;
                break;
        }
    }

    public function getGoods($code) {
        $data = DB::table('goods')
            ->where('own_code', $code)->where('status_del', 1)
            ->where('status_good', 1)->get();
        foreach ($data as $key => $value) {
            $count = DB::table('checks_log')->where('good_code', $value->code)->count();
            $value->last_num = $value->num - $count;
            if ($value->last_num > 0) {
                $value->last_status = 1;
            } else {
                $value->last_status = 0;
            }
        }
        return $data;
    }
}
