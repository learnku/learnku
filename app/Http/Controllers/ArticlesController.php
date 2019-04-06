<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function show(Request $request)
    {
        return redirect()->route('blog.articles.show', $request->article);
    }
}
