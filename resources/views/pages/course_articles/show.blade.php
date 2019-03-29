@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>CourseArticle / Show #{{ $course_article->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('course_articles.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('course_articles.edit', $course_article->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>Title</label>
<p>
	{{ $course_article->title }}
</p> <label>Body</label>
<p>
	{{ $course_article->body }}
</p> <label>Reply_count</label>
<p>
	{{ $course_article->reply_count }}
</p> <label>View_count</label>
<p>
	{{ $course_article->view_count }}
</p> <label>Slug</label>
<p>
	{{ $course_article->slug }}
</p> <label>Course_books_id</label>
<p>
	{{ $course_article->course_books_id }}
</p> <label> Courses_section_id</label>
<p>
	{{ $course_article-> courses_section_id }}
</p> <label>User_id</label>
<p>
	{{ $course_article->user_id }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
