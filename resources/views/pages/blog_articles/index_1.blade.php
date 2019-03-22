@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          BlogArticle
          <a class="btn btn-success float-xs-right" href="{{ route('blog.articles.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($blog_articles->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>Title</th> <th>Body</th> <th>User_id</th> <th>Category_id</th> <th>Reply_count</th> <th>View_count</th> <th>Last_reply_user_id</th> <th>Order</th> <th>Excerpt</th> <th>Slug</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($blog_articles as $blog_article)
              <tr>
                <td class="text-xs-center"><strong>{{$blog_article->id}}</strong></td>

                <td>{{$blog_article->title}}</td> <td>{{$blog_article->body}}</td> <td>{{$blog_article->user_id}}</td> <td>{{$blog_article->category_id}}</td> <td>{{$blog_article->reply_count}}</td> <td>{{$blog_article->view_count}}</td> <td>{{$blog_article->last_reply_user_id}}</td> <td>{{$blog_article->order}}</td> <td>{{$blog_article->excerpt}}</td> <td>{{$blog_article->slug}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('blog.articles.show', $blog_article->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('blog.articles.edit', $blog_article->id) }}">
                    E
                  </a>

                  <form action="{{ route('blog.articles.destroy', $blog_article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $blog_articles->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
