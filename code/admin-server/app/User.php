<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'email', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'id', 'creared_at', 'updated_at'
    ];

    //在数据保存到数据库之前会对密码进行一个预处理
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = \Hash::make($password);
    }

    public function getUserCode($array) {
        return $this->where('name', $array['name'])->select('code')->first();
    }

    public function distUser($name) {
        return $this->where('name', $name)->exists();
    }

    public function userDetails()
    {
        return $this->hasOne('App\Model\UserDetails', 'user_code', 'code');
    }

    public function getUsers($name, $code) {
        return $this->where('name', 'like', $name.'%')
            ->where('status_del', 1)->where('code', '<>', $code)
            ->with('userDetails')->get();
    }
}
