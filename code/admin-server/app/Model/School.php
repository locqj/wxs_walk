<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';
    public $timestamps = false;
    
    /**
     * [getSchoolName 获取学校名称]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
 	public function getSchoolName($code) {
 		$data = $this->where('code', $code)->first();
 		return $data->name;
 	}   
}
