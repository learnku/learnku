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
        $reply->content = $request['content'];
        $reply->user_id = Auth::id();
        $reply->article_id = $request->article_id;
        $reply->save();

        return redirect()->to($reply->article->link())->with('success', '评论创建成功！');
	}

	public function edit(BlogReply $blog_reply)
	{
        $this->authorize('update', $blog_reply);
		return view('blog.replies.create_and_edit', compact('blog_reply'));
	}

	public function update(BlogReplyRequest $request, BlogReply $blog_reply)
	{
		$this->authorize('update', $blog_reply);
		$blog_reply->update($request->all());

		return redirect()->route('blog.replies.show', $blog_reply->id)->with('message', 'Updated successfully.');
	}

	public function destroy(BlogReply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

        return redirect()->route('blog.replies.index')->with('success', '评论删除成功！');
	}
}
