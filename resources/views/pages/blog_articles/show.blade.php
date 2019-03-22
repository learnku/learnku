@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>BlogArticle / Show #{{ $blog_article->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('blog.articles.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('blog.articles.edit', $blog_article->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>Title</label>
<p>
	{{ $blog_article->title }}
</p> <label>Body</label>
<p>
	{{ $blog_article->body }}
</p> <label>User_id</label>
<p>
	{{ $blog_article->user_id }}
</p> <label>Category_id</label>
<p>
	{{ $blog_article->category_id }}
</p> <label>Reply_count</label>
<p>
	{{ $blog_article->reply_count }}
</p> <label>View_count</label>
<p>
	{{ $blog_article->view_count }}
</p> <label>Last_reply_user_id</label>
<p>
	{{ $blog_article->last_reply_user_id }}
</p> <label>Order</label>
<p>
	{{ $blog_article->order }}
</p> <label>Excerpt</label>
<p>
	{{ $blog_article->excerpt }}
</p> <label>Slug</label>
<p>
	{{ $blog_article->slug }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
