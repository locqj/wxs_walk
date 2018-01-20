<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    public $timestamps = false;
    
    public function getDepartmentName($code) {
    	$data = $this->where('code', $code)->first();
    	return $data->name;
    }
}
