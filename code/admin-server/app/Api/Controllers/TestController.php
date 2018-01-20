<?php

namespace App\Api\Controllers;
use App\Api\Traits\Responder;
use DB;

class TestController extends Controller
{
    public function test() {
        return 'ok';
    }
}
