<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecksLog extends Model
{
    protected $table = 'checks_log';
    public $timestamps = false;

    public function good()
    {
        return $this->hasOne('App\Goods', 'code', 'good_code');
    }
    public function getGoodChecks($good_code)
    {
        $data = $this->whereIn('good_code', $good_code)
            ->with('good')->get();
        return $data;
    }



}
