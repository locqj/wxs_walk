<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use DB;
use Session;

class GoodsController extends Controller
{
    public function index() {
        $data = DB::table('goods')
            ->where('own_code', Session::get('business'))
            ->where('status_good', 1)
            ->where('status_del', 1)
            ->paginate(15);

        return view('goods.goods', compact('data'));
    }

    /**
     * [addGood 添加商品]
     * @param Request $request [description]
     */
    public function addGood(Request $request) {
        // var_dump($request->all()) ;
        if ($request->isMethod('POST')) {
            $count_good = DB::table('goods')->count();
            $filename = $this->uploadImg($request->file('good_img'));
            if ($request->get('substatus') == 1) {
                $data = DB::table('goods')->insert([
                    'name' => $request->get('good_name'),
                    'code' => 'G'.$count_good,
                    'num' => $request->get('good_num'),
                    'remark' => $request->get('good_remark'),
                    'status_del' => 1,
                    'status_good' => 1,
                    'img' => 'https://www.locqj.top/storage/upimgs/'.$filename,
                    'power' => $request->get('good_power'),
                    'own_code' => Session::get('business'),
                    'time' => time()
                ]);
                if ($data) {
                    return response()->json($this->responseSuccess("添加成功"));
                } else {
                    return response()->json($this->responseFailed("添加失败"));
                }
            } else {
                $data = DB::table('goods')->where('code', $request->get('substatus'))
                    ->update([
                        'name' => $request->get('good_name'),
                        'code' => 'G'.$count_good,
                        'num' => $request->get('good_num'),
                        'remark' => $request->get('good_remark'),
                        'status_del' => 1,
                        'status_good' => 1,
                        'img' => '/storage/upimgs/'.$filename,
                        'power' => $request->get('good_power'),
                        'own_code' => Session::get('business'),
                        'time' => time()
                    ]);
                if ($data) {
                    return response()->json($this->responseSuccess("修改成功"));
                } else {
                    return response()->json($this->responseFailed("修改失败"));
                }
            }



       }
    }
    /**
     * [public 商品详情]
     * @var [type]
     */
    public function getGood($code) {
        $data = DB::table('goods')->where('code', $code)->first();
        $check_count = DB::table('checks_log')->where('good_code', $code)->count();
        $data->time = date('Y-m-d', $data->time);
        $data->last_num = $data->num - $check_count;
        return response()->json($data);
    }

    public function delGood($code) {
        $data = DB::table('goods')->where('code', $code)->update(['status_del' => 0]);
        if ($data) {
            return response()->json($this->responseSuccess("删除成功"));
        }
    }

}
