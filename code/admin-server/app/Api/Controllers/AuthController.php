<?php
namespace App\Api\Controllers;

use App\User;
use App\Model\UserDetails;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use Redirect;
use JWTAuth;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{   
    public function _initialize()
    {
        $this->cross();
    }
    public function cross()
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:GET,POST,PATCH,PUT,OPTIONS');
    }
    /**
     * [authenticate 登录验证]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json($this->responsePwdError());
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }        
        // all good so return the token
        // return $credentials;
        $user = new User();
        $user_info = new UserDetails();
        $user_code = $user->getUserCode($credentials);
        $user = $user_info->userInfo($user_code->code);
        $user->img = json_decode($user->img)[0];
        return response()->json($this->responseData(compact('token', 'user')));
    }

    //获取当前的用户
    public function getAuthenticatedUser($token)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}