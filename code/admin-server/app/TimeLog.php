<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $table = 'time_log';
    public $timestamps = false;

    public function tInsert($openid, $step) {
        return $this->insert([
            'openid' => $openid,
            'step' => $step,
            'time' => strtotime(date("Y-m-d"),time())
        ]);
    }

    public function tUpdate($openid, $step) {
        return $this->where('openid', $openid)
            ->where('time', strtotime(date("Y-m-d"),time()))
            ->update(['step' => $step]);
    }

    public function tGet($openid) {
        return $this->where('openid', $openid)
            ->where('time', strtotime(date("Y-m-d"),time()))
            ->first();
    }

}
