<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use App\Models\CourseBookOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Object_;

class CoursePurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, CourseBook $book, CourseBookOrder $order)
    {
        $step = $request->step ? $request->step : null;
        // 根据 $type 字段加载不同视图
        $type = $request->type ? $request->type : null;

        $book_id = $book->id;
        $user_id = Auth::id();
        $data = [
            'order_id' => null,
        ];

        // 第二步：
        if ($step && $type) {
            // 如果订单不存在则，创建订单
            if (CourseBookOrder::where('user_id', $user_id)->where('course_book_id', $book_id)->doesntExist()){
                $order->flag = 0;
                $order->user_id = $user_id;
                $order->course_book_id = $book_id;
                $order->save();
                // 为订单 id 赋值
            } else {
                // $data['order_id'] = CourseBookOrder::where('user_id', $user_id)->where('course_book_id', $book_id)->value('id');
                $order = CourseBookOrder::where('user_id', $user_id)->where('course_book_id', $book_id)->first();
            }

            // 基础数据
            $data['name'] = $order->book->title;
            $data['order_id'] = $order->id;
            $data['prices'] = $order->book->prices;
            $data['ip'] = $request->getClientIp();

            // 1 小时支付时间 或者 未请求过
            if (now()->timestamp >= $order->updated_at->addHour()->timestamp || !$order->wx_out_trade_no) {
                $order->updated_at = now();
                $order->save();

                // 请求 微信接口
                if ($type == '1') {
                    $this->_WeChatCode($order, $data, true);
                }
            }

            // return view('pages.course_purchases.qrcode.' . $type, compact('data', 'order', 'book'));
            return view('pages.course_purchases.qrcode.1', compact('data', 'order', 'book'));
        }

        // 第一步
        return view('pages.course_purchases.index', compact('data', 'book'));
    }

    /**
     * 获取微信支付二维码
     * @param $order
     * @param $data
     * @param bool $type 是否重新请求
     * @return mixed
     */
    private function _WeChatCode($order, $data, $type = false)
    {
        if ($type) {
            $payment_id = $data['order_id'] . '_' . now()->timestamp;
            $post_data = [
                'name' => $data['name'],
                'price' => $data['prices'],
                'productId' => $payment_id,
                'ip' => $data['ip'],
            ];
            $rtn = $this->me_curl('http://api.dunheic.com/createOrderForGJ', $post_data);

            if ($rtn) {
                if ($rtn->status == '1') {
                    $order->payment_id = $payment_id;
                    $order->wx_out_trade_no = $rtn->data->out_trade_no;
                    $order->wx_code_url = $rtn->data->code_url;
                    $order->save();
                }
            }

            return $rtn;
        }
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
