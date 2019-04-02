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
}
