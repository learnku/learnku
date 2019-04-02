<?php

namespace App\Http\Controllers;

use App\Models\CourseBook;
use Illuminate\Http\Request;

class CoursePurchasesController extends Controller
{
    public function index(Request $request, CourseBook $book)
    {
        $step = $request->step ? $request->step : null;
        $type = $request->type ? $request->type : null;

        if ($step && $type) {
            return view('pages.course_purchases.qrcode.' . $type, compact('book'));
        }
        return view('pages.course_purchases.index', compact('book'));
    }
}
