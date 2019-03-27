<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogTagsLinkArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    // 列表页
	public function index(Request $request)
	{
        $blog_articles = BlogArticle::withOrder($request->order)
        	->select('blog_articles.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_articles.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->paginate(20);

		// $blog_articles = BlogArticle::with(['category', 'user'])->paginate();
		return view('pages.blog_articles.index', compact('blog_articles'));
	}

    // 详情页
    public function show(BlogArticle $article)
    {
        // 回复数据
        $replies = $article->replies()->with('user')
            ->where('verify', '=', 1)
            ->select('blog_replies.*', 'images.path as avatar_path')
            ->leftJoin('images', function ($join){
                $join->on('images.user_id', '=', 'blog_replies.user_id')
                    ->where('images.image_type', '=', 'avatar');
            })->get();

        // 文章主体
        $article->body = $this->markdownToHtml($article->body);
        return view('pages.blog_articles.show', compact('article', 'replies'));
    }

    // 创建页面
	public function create(BlogArticle $article)
	{
        $this->authorize('admin', $article);
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('pages.blog_articles.create_and_edit', compact('article', 'categories', 'tags'));
	}

	// 保存文章
	public function store(BlogArticleRequest $request, BlogArticle $article, BlogCategory $category)
	{
        $this->authorize('admin', $article);
	    $category_id = $request->category_id;
        $user_id = Auth::id();

        // 更新 blog_tags 表
        $tag_ids = $this->updateTagsTable($request->tags);

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $category_id,
        ];
        $article->fill($data);
        $article->user_id = $user_id;
        $article->save();

        // 更新 blog_tags_link_articles 表
        $article_id = $article->id;
        $this->updateTagsLinkArticlesTable($article_id, $tag_ids);

		return redirect()->route('blog.articles.show', $article->id)->with('success', '文章创建成功.');
	}

    // 编辑页面
	public function edit(BlogArticle $article)
	{
        $this->authorize('update', $article);
	    $categories = BlogCategory::all();

        $articleTags = $article->tags()->get()->toArray();
        $tmpArr = [];
        foreach ($articleTags as $item){
            array_push($tmpArr, $item['name']);
        };
        $articleTags = implode(',', $tmpArr);

        $tags = BlogTag::all();

		return view('pages.blog_articles.create_and_edit', compact('article', 'categories', 'articleTags', 'tags'));
	}

    // 更新文章
	public function update(BlogArticleRequest $request, BlogArticle $article)
	{
		$this->authorize('update', $article);

        $tag_ids = $this->updateTagsTable($request->tags);

        $category_id = $request->category_id;
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $category_id,
        ];
        $article->update($data);

        $article_id = $article->id;
        $this->updateTagsLinkArticlesTable($article_id, $tag_ids);

		return redirect()->route('blog.articles.show', $article->id)->with('success', '更新成功.');
	}

    // 删除文章
	public function destroy(BlogArticle $article)
	{
		$this->authorize('destroy', $article);
		$article->delete();

		return redirect()->route('blog.articles.index')->with('success', '删除成功.');
	}

    /**
     * 更新 blog_tags 表
     * @param string $reqTags 提交的 tags 字段
     * @return array $tag_ids
     */
    private function updateTagsTable($reqTags)
    {
        $tags = new BlogTag();
        // 一篇文章对应多个 tag 标签
        $tag_ids = [];
        // 文章id 只有保存文章后才可以获得文章id
        $article_id = null;
        // 提交的 tag->name 字段

        $reqTags = explode(',', $reqTags);
        foreach ($reqTags as $tag){
            if (!empty($tag) && !$tags->hasTag($tag)) {
                $data = [
                    'name'=> $tag,
                ];
                BlogTag::insert($data);
            }
            if (!empty($tag)) {
                $tag_id = $tags->getTag($tag);
                foreach ($tag_id as $item) {
                    array_push($tag_ids, $item);
                }
            }
        }

        return $tag_ids;
    }

    /**
     * 更新 blog_tags_link_articles 表
     * @param $article_id
     * @param array $tag_ids 通过 `this->updateTagsTable` 获得
     */
    private function updateTagsLinkArticlesTable($article_id, $tag_ids)
    {
        $tagsLinkArticles = new BlogTagsLinkArticle();
        if (is_numeric($article_id)) {
            $tagsLinkArticles->deleteArticleItem($article_id);
            foreach ($tag_ids as $item) {
                $data = [
                    'article_id' => $article_id,
                    'tag_id' => $item,
                    'user_id'=> Auth::id(),
                ];
                BlogTagsLinkArticle::insert($data);
            }
        }
    }
}
