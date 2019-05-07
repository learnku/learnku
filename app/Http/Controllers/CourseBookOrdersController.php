<?php

namespace App\Http\Controllers;

use App\Models\CourseBookOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseBookOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = CourseBookOrder::where('user_id', Auth::id())->get();
        return view('pages.course_book_orders.index', compact('orders'));
    }

    public function show(CourseBookOrder $order)
    {
        $data = [
            'productId'=> $order->payment_id,
            'out_trade_no' => $order->wx_out_trade_no,
        ];


        $rtn = $this->me_curl('http://api.dunheic.com/gj/notify_url', $data);
        if ($rtn && $rtn->status === 1) {
            if (isset($rtn->data->pay) && $rtn->data->pay === 1) {
                $order->flag = '1';
                $order->save();
            }
        }

        if ($order->flag == '1') {
            return [
                'status'=> 1,
                'msg' => '支付成功',
            ];
        }
    }

    public function edit(Request $request, CourseBookOrder $order)
    {
        dd('edit');
    }

    public function update(Request $request, CourseBookOrder $order)
    {

    }

    public function destroy(Request $request, CourseBookOrder $order)
    {

    }


    /**
     * @param string $url 请求地址
     * @param Object $data 设置post数据
     * @return mixed
     */
    protected function me_curl($url, $data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        // curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true); //  PHP 5.6.0 后必须开启

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        //执行命令
        $rtn = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);

        //显示获得的数据
        return json_decode($rtn);
    }
}
