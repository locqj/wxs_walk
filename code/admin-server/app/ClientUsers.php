<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientUsers extends Model
{
    protected $table = 'client_users';
    public $timestamps = false;

    public function cInsert($openid, $step_log, $head_img, $nickname) {
        return $this->insert([
            'openid' => $openid,
            'step_log' => $step_log,
            'last_time' => time(),
            'head_img' => $head_img,
            'nickname' => $nickname
        ]);
    }

    public function cUpdateStep($openid, $step_log, $nickname, $head_img) {
        return $this->where('openid', $openid)
            ->increment('step_log', $step_log, ['nickname' => $nickname, 'head_img' => $head_img]);
    }

    public function cUpdatePower($openid, $power) {
        return $this->where('openid', $openid)->increment('power', $power);
    }

    public function cGet($openid) {
        return $this->where('openid', $openid)->select('step_log', 'target_step', 'power')->first();
    }
}
