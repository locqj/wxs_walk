<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    public $timestamps = false;

    public function checks()
    {
        return $this->hasMany('App\ChecksLog', 'good_code', 'code');
    }

    public function getGoods($own_code)
    {
        $data = $this->where('own_code', $own_code)
            ->where('status_good', 1)
            ->where('status_del', 1)
            ->get();
        return $data;
    }

    public function getCodes($own_code)
    {
        $data = $this->where('own_code', $own_code)
            ->where('status_good', 1)
            ->where('status_del', 1)
            ->pluck('code');
        return $data;
    }
}
