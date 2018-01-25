<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Goods;
use App\ChecksLog;


class CheckController extends Controller
{
    public function index(Request $request) {
        $goods = new Goods;
        $checks_log = new ChecksLog;
        $good_lists = $goods->getGoods(Session::get('business'));
        $good_value = $goods->getCodes(Session::get('business'));
        if ($request->has('good_code')) {
            $check_list = $checks_log->getGoodChecks(array($request->get('good_code')));
        } else {
            $check_list = $checks_log->getGoodChecks($good_value);

        }
        // return $good_value;
        // return $check_list;
        return view('check.check', compact('good_lists', 'check_list'));
    }
}
