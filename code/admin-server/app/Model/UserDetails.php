<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $table = 'user_details';
    public $timestamps = false;
    
    
    
    public function userInfo($code) {
        return $this->where('user_code', $code)->with('users', 'department', 'school')->first();
    }
    /**
     * [Nickname 获取昵称]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getNickname($code) {
        $data = $this->where('user_code', $code)->first();
        return $data->nickname;
    }



    public function users() {
        return $this->hasOne('App\User', 'code', 'user_code');
    }

    public function department() {
        return $this->hasOne('App\Model\Department', 'code', 'department_code');
    }

    public function school() {
        return $this->hasOne('App\Model\School', 'code', 'school_code');
    }
}
