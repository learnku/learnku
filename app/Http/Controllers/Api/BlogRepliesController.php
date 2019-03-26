<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogArticle;
use App\Models\BlogReply;
use Illuminate\Http\Request;
use App\Http\Requests\BlogReplyRequest;
use Illuminate\Support\Facades\Auth;

class BlogRepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function store(BlogReplyRequest $request, BlogReply $reply)
	{
        $reply->content = $request['content'];
        $reply->user_id = Auth::id();
        $reply->article_id = $request->article_id;
        $reply->save();

        return $this->defaultApi([
            'msg'=> '评论发表成功.'
        ]);
        // return redirect()->to($reply->article->link())->with('success', '评论创建成功！');
	}

	public function destroy(BlogReply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

        return $this->noContent();
        // return redirect()->route('blog.replies.index')->with('success', '评论删除成功！');
	}
}
