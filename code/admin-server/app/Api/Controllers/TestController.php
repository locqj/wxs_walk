<?php

namespace App\Api\Controllers;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use DB;

class TestController extends Controller
{
    public function setSession(Request $request) {
        $request->session()->put('locqj', 'asd');
    }
    public function getSession(Request $request) {
        return $request->session()->get('locqj');
    }
}
