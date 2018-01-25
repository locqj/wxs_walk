<?php

namespace App\Http\Controllers;
use App\Api\Traits\Responder;
use DB;
use Storage;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    use Responder;

    /**
     * 获取客户端ip
     * @return [type]
     */
    public function ip() {
	    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
	    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	        $ip = getenv('HTTP_CLIENT_IP');
	    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	        $ip = getenv('HTTP_X_FORWARDED_FOR');
	    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	        $ip = getenv('REMOTE_ADDR');
	    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	    return $res;
	    //dump(phpinfo());//所有PHP配置信息
	}

	/**
     * [getSchool 获取school_code]
     * @param  [type] $school_name [description]
     * @return [type]              [description]
     */
    public function getSchoolCode($name)
    {
    	$dist = DB::table('school')->where('name', $name)->first();
    	if ($dist) {
    		return $dist->code;
    	} else {
			$count = DB::table('school')->count();
			$code = 'S'.$count;
    		$insert = DB::table('school')->insert(['name' => $name, 'code' => $code]);
    		if ($insert) {
	    		return $code;
    		}
    	}
    }
    /**
     * [getSchool 获取department_code]
     * @param  [type] $school_name [description]
     * @return [type]              [description]
     */
    public function getDepartmentCode($name)
    {
    	$dist = DB::table('department')->where('name', $name)->first();
    	if ($dist) {
    		return $dist->code;
    	} else {
    		$count = DB::table('department')->count();
    		$code = 'D'.$count;
    		$insert = DB::table('department')->insert(['name' => $name, 'code' => $code]);
    		if ($insert) {
	    		return $code;
    		}
    	}
    }

    public function storeSchoolDepartment($school_code, $department_code)
    {
    	$dist = DB::table('school_department')
    		->where('school_code', $school_code)
    		->where('department_code', $department_code)
    		->exists();
    	if(!$dist) {
    		DB::table('school_department')->insert(
    			[
    				'school_code' => $school_code,
    				'department_code' => $department_code
    			]);
    	}
    	return 1;
    }

        /**
     * 微信展示时间的方法
     * @param $addTime
     * @return string
     */
    public static function getChatTimeStr($addTime) {
        $nowTime = time();

        if($addTime > $nowTime) {
            return "";
        }

        //返回的时间
        $timeStr = "";
        //获取当前时间
        $addTime = explode(',', date('Y,n,j,w,a,h,i,y', $addTime));//年，月，日，星期，上下午，时，分
        $nowTime = explode(',', date('Y,n,j,w,a,h,i,y', $nowTime));

        $dayPerMonthAddTime = self::getDayPerMonth($addTime[0]);
        $week = array(0=>"星期日",1=>"星期一",2=>"星期二",3=>"星期三",4=>"星期四",5=>"星期五",6=>"星期六");
        //如果时间差小于一天的,显示（上午 时间） / （下午 时间）
        if($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $addTime[2] == $nowTime[2]) {
            $timeStr .= $addTime[5] . ":" . $addTime[6];
        } else if(($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $addTime[2] == $nowTime[2]-1)
            || ($addTime[0] == $nowTime[0] && $nowTime[1]-$addTime[1] == 1 && $dayPerMonthAddTime[$addTime[1]] == $addTime[2] && $nowTime[2] == 1)
            || ($nowTime[0]-$addTime[0] == 1 && $addTime[1] == 12 && $addTime[2] == 31 && $nowTime[1] == 1 && $nowTime[2] == 1)) { //如果时间差在昨天,三种情况（同一月份内跨一天、月末跨越到月初、年末跨越到年初）显示格式：昨天 时:分 上午/下午
            $timeStr .= "昨天 " . $addTime[5] . ":" . $addTime[6] . " ";
        } else if(($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $nowTime[2] - $addTime[2] < 7)
            || ($addTime[0] == $nowTime[0] && $nowTime[1]-$addTime[1] == 1 && $dayPerMonthAddTime[$addTime[1]]-$addTime[2]+$nowTime[2] < 7
                || ($nowTime[0]-$addTime[0] == 1 && $addTime[1] == 12 && $nowTime[1] == 1 && 31-$addTime[2]+$nowTime[2] < 7))) { //如果时间差在一个星期之内的,也是三种情况，显示格式：星期 时:分 上午/下午

            $timeStr .= $week[$addTime[3]] . " " . $addTime[5] . ":" . $addTime[6];
        } else { //显示格式：月/日/年 时:分 上午/下午
            $timeStr .= $addTime[1] . "/" . $addTime[2] . "/" . $addTime[7] . " " . $addTime[5] . ":" . $addTime[6];
        }

        if($addTime[4] == "am") {
            $timeStr .= " 上午";
        } else if($addTime[4] == "pm") {
            $timeStr .= " 下午";
        }

        return $timeStr;

    }

    //根据年份获取每个月份的总天数和每年最后一个月的天数
    public static function getDayPerMonth($year) {
        $arr = array(
            1 => 31,
            3 => 31,
            4 => 30,
            5 => 31,
            6 => 30,
            7 => 31,
            8 => 31,
            9 => 30,
            10 => 31,
            11 => 30,
            12 => 31
        );
        //闰年
        if(($year%4==0&&$year%100!=0) || ($year%400==0)) {
            $arr[2] = 29;
        } else {
            $arr[2] = 28;
        }
        return $arr;
    }

    /**
     * [uploadImg 上传图片]
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function uploadImg($file) {
        //判断文件是否上传成功
        if($file->isValid()){
            //获取原文件名
            $originalName = $file->getClientOriginalName();
            //扩展名
            $ext = $file->getClientOriginalExtension();
            //文件类型
            $type = $file->getClientMimeType();
            //临时绝对路径
            $realPath = $file->getRealPath();

            $filename = time().uniqid().'.'.$ext;
            $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
            return $filename;
        }
    }



}
