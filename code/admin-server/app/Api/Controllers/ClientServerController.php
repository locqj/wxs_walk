<?php

namespace App\Api\Controllers;
use App\Api\Traits\Responder;
use DB;
use Session;
use Illuminate\Http\Request;
use App\ClientUsers;

class ClientServerController extends Controller
{
    public function setTarget(Request $request)
    {
        $data = DB::table('client_users')
            ->where('openid', $request->get('openid'))
            ->update(['target_step' => $request->get('target_step')]);
        return response()->json($this->responseSuccess("ok"));
    }
}
