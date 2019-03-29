@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          CourseArticle
          <a class="btn btn-success float-xs-right" href="{{ route('course_articles.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($course_articles->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>Title</th> <th>Body</th> <th>Reply_count</th> <th>View_count</th> <th>Slug</th> <th>Course_books_id</th> <th> Courses_section_id</th> <th>User_id</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($course_articles as $course_article)
              <tr>
                <td class="text-xs-center"><strong>{{$course_article->id}}</strong></td>

                <td>{{$course_article->title}}</td> <td>{{$course_article->body}}</td> <td>{{$course_article->reply_count}}</td> <td>{{$course_article->view_count}}</td> <td>{{$course_article->slug}}</td> <td>{{$course_article->course_books_id}}</td> <td>{{$course_article-> courses_section_id}}</td> <td>{{$course_article->user_id}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('course_articles.show', $course_article->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('course_articles.edit', $course_article->id) }}">
                    E
                  </a>

                  <form action="{{ route('course_articles.destroy', $course_article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $course_articles->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
