<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\CourseArticle;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function store(ReplyRequest $request, Reply $reply)
	{
        abort(403);
        $reply->content = $request['content'];
        $reply->user_id = Auth::id();
        $reply->article_id = $request->article_id;
        $reply->save();

        return redirect()->to($reply->article->link())->with('success', '评论创建成功！');
	}

	public function edit(Reply $reply)
	{
        $this->authorize('update', $reply);
		return view('pages.replies.edit', compact('reply'));
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);
        $reply->update($request->all());
        $reply->verify = 0;
        $reply->save();

        $link = $reply->article->link();

        return redirect()->to($link)->with('success', '更新成功，需要重新接受管理员审核...');
	}

	public function destroy(Reply $reply)
	{
        abort(403);
		$this->authorize('destroy', $reply);
		$reply->delete();

        return redirect()->route('replies.index')->with('success', '评论删除成功！');
	}
}
