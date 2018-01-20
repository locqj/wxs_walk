<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserManages extends Model
{
    protected $table = 'user_manages';
    public $timestamps = false;
    
    public function disData($user_code, $friend_code) {
    	return $this->where('user_code', $user_code)
    		->where('friend_code', $friend_code)->exists();
    }

    public function doUpdate($user_code, $friend_code, $status) {
    	return $this->where('user_code', $user_code)->where('friend_code', $friend_code)->update(['status' => $status]);
    }

    /**
     * [disdatafirst 判断并获取数据]
     * @param  [type] $user_code   [description]
     * @param  [type] $friend_code [description]
     * @return [type]              [description]
     */
    public function disFirst($user_code, $friend_code) {
    	return $this->where('user_code', $user_code)
    		->where('friend_code', $friend_code)->first();
    }

    public function getWaitAcceptUsers($user_code) {
    	return $this->where('user_code', $user_code)
    		->where('status', 0)->with('wUsers', 'wUserDetails')->get();
    }
    /**
     * [getFriends 已经接受的，成为朋友名单]
     * @param  [type] $user_code [description]
     * @return [type]            [description]
     */
    public function getFriends($user_code) {
    	return $this->where('user_code', $user_code)
    		->where('status', 1)->with('wUsers', 'wUserDetails')->get();	
    }
    /**
     * [getRefuse 拒绝添加朋友]
     * @param  [type] $user_code [description]
     * @return [type]            [description]
     */
    public function getRefuse($user_code) {
    	return $this->where('user_code', $user_code)
    		->where('status', 2)->with('aUsers', 'aUserDetails')->get();
    }

    public function getAcceptUsers($friend_code) {
    	return $this->where('friend_code', $friend_code)
    		->where('status', 0)->with('aUsers', 'aUserDetails')->get();
    }


    /**
     * [wUsers 等待对方添加朋友关系]
     * @return [type] [description]
     */
    public function wUsers() {
        return $this->hasOne('App\User', 'code', 'friend_code');
    }

    /**
     * [wUserDetails 等待对方添加朋友关系]
     * @return [type] [description]
     */
	public function wUserDetails()
    {
        return $this->hasOne('App\Model\UserDetails', 'user_code', 'friend_code');
    }


    /**
     * [AUsers 接受对方添加朋友关系]
     */
    public function aUsers() {
        return $this->hasOne('App\User', 'code', 'user_code');
    }
    /**
     * [AUserDetails 接受对方添加朋友关系]
     */
	public function aUserDetails()
    {
        return $this->hasOne('App\Model\UserDetails', 'user_code', 'user_code');
    }



}
