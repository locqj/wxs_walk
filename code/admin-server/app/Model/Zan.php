<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Zan extends Model
{
    protected $table = 'zans';
    public $timestamps = false;
    
    
    /**
     * [getZan 获取每个朋友圈对应的赞]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getZan($code) {
        return $this->where('moment_code', $code)->with('userDetails')->get();
    }
    /**
     * [disExists 判断该用户是否有赞]
     * @param  [type] $moment_code [description]
     * @param  [type] $user_code   [description]
     * @return [type]              [description]
     */
    public function disExists($moment_code, $user_code) {
        return $this->where('moment_code', $moment_code)->where('user_code', $user_code)->with('users', 'userDetails')->exists();
    }
    /**
     * [del 取消点赞]
     * @param  [type] $moment_code [description]
     * @param  [type] $user_code   [description]
     * @return [type]              [description]
     */
    public function del($moment_code, $user_code) {
        return $this->where('moment_code', $moment_code)->where('user_code', $user_code)->delete();
    }





    /**
     * [users 用户表关联]
     * @return [type] [description]
     */
    public function users()
    {
        return $this->hasOne('App\User', 'code', 'user_code');
    }

    /**
     * [userDetails 用户表关联]
     * @return [type] [description]
     */
    public function userDetails()
    {
        return $this->hasOne('App\Model\UserDetails', 'user_code', 'user_code');
    }

    
}
