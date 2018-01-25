<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use Session;

use DB;

class LoginController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function signin() {
        return view('login.signin');
    }

    public function signout() {
        return view('login.signout');
    }

    public function logout() {
        Session::pull('business');
        Session::pull('username');
        return Redirect::to('/');
    }
    /**
     * [distBusinessName 验证商户名]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function distBusinessName(Request $request) {
        $data = DB::table('users')->where('name', $request->get('name'))->exists();
        if (!$data) {
            return response()->json($this->responseSuccess("商户名可用"));
        } else {
            return response()->json($this->responseFailed("商户名不可用"));
        }
    }
    /**
     * [signout 提交注册信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function signoutUser(Request $request) {
        $count = DB::table('users')->count();
        $dist = DB::table('users')->where('name', $request->get('name'))->exists();
        if (!$dist) {
            $data = DB::table('users')->insert([
                'name' => $request->get('name'),
                'password' => md5($request->get('pwd').'hzx'),
                'code' => 'hzx'.$count,
                'status_del' => 1,
                'status_use' => 0
            ]);
            if ($data) {
                return response()->json($this->responseSuccess("注册成功"));
            } else {
                return response()->json($this->responseFailed("注册失败，网络原因，稍后重试"));
            }
        } else {
            return response()->json($this->responseFailed("商户名不可用"));
        }
    }

    public function doSignin(Request $request) {
        $data = DB::table('users')
            ->where('name', $request->get('name'))
            ->where('password', md5($request->get('pwd').'hzx'))
            ->first();
        if ($data) {
            Session::put('business', $data->code);
            Session::put('username', $data->name);
            return response()->json($this->responseSuccess("登陆成功"));
        } else {
            return response()->json($this->responseFailed("账号密码错误！"));
        }
    }


}
