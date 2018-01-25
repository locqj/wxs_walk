<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RankingList extends Model
{
    protected $table = 'ranking_list';
    public $timestamps = false;

    public function rGet($openid) {
        return $this->where('openid', $openid)
            ->where('time_log', strtotime(date("Y-m-d"),time()))->first();
    }

    public function rInsert($openid, $step_day, $step_month) {
        return $this->insert([
            'openid' => $openid,
            'step_day' => $step_day,
            'step_month' => $step_month,
            'time_log' => strtotime(date("Y-m-d"),time())
        ]);
    }

    public function rUpdate($openid, $step_day, $step_month) {
        return $this->where('openid', $openid)
            ->where('time_log', strtotime(date("Y-m-d"),time()))
            ->update([
                'step_day' => $step_day,
                'step_month' => $step_month
            ]);
    }

    public function rGetRankByDay() {
        return $this->where('time_log', strtotime(date("Y-m-d"),time()))
            ->orderBy('step_day','desc')->with('rClientUsers')->get();
    }

    public function rGetRankByMonth() {
        return $this->where('time_log', strtotime(date("Y-m-d"),time()))
            ->orderBy('step_month','desc')->with('rClientUsers')->get();
    }

    public function rClientUsers() {
        return $this->hasOne('App\ClientUsers', 'openid', 'openid');
    }
}
