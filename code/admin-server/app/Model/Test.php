<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_login';
    /**
     * The attributes that are mass assignable.
     * 白名单
     * @var array
     */
    protected $fillable = [
        'name', 'pwd', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd', 'code',
    ];

    //在数据保存到数据库之前会对密码进行一个预处理
    public function setpwdAttribute($pwd){
        $this->attributes['pwd'] = \Hash::make($pwd);
    }

    public function setCodeAttribute($name){
        $this->attributes['code'] = $name;
    }

    // public function add($data){
    // 	$this->name = $data['name'];
    // 	$this->code = $data['name'];
    // 	$this->pwd = bcrypt($data['pwd']);
    // 	if ($this->save()) {
    // 		return $this;
    // 	}
    // }
    public function distUser($name){
    	return $this->where('name', $name)->exists();
    }


}
