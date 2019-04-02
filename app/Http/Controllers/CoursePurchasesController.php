<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use App\Models\CourseBookOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $data['order_id'] = $order->id;
            } else {
                $data['order_id'] = CourseBookOrder::where('user_id', $user_id)->where('course_book_id', $book_id)->value('id');
            }

            return view('pages.course_purchases.qrcode.' . $type, compact('data', 'book'));
        }

        // 第一步
        return view('pages.course_purchases.index', compact('data', 'book'));
    }
}
