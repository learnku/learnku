<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        abort(403);
        $reply->content = $request['content'];
        $reply->user_id = Auth::id();
        $reply->article_id = $request->article_id;
        $reply->save();

        return redirect()->to($reply->article->link())->with('success', '评论创建成功！');
	}

	public function edit(BlogReply $reply)
	{
        $this->authorize('update', $reply);
		return view('pages.blog_replies.edit', compact('reply'));
	}

	public function update(BlogReplyRequest $request, BlogReply $reply)
	{
		$this->authorize('update', $reply);
        $reply->update($request->all());
        $reply->verify = 0;
        $reply->save();

		return redirect()->route('blog.articles.show', $reply->article_id)->with('success', '更新成功，需要重新接受管理员审核...');
	}

	public function destroy(BlogReply $reply)
	{
        abort(403);
		$this->authorize('destroy', $reply);
		$reply->delete();

        return redirect()->route('blog.replies.index')->with('success', '评论删除成功！');
	}
}
