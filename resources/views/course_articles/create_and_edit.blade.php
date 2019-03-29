@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          CourseArticle /
          @if($course_article->id)
            Edit #{{ $course_article->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($course_article->id)
          <form action="{{ route('course_articles.update', $course_article->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('course_articles.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $course_article->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $course_article->body ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="reply_count-field">Reply_count</label>
                    <input class="form-control" type="text" name="reply_count" id="reply_count-field" value="{{ old('reply_count', $course_article->reply_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="view_count-field">View_count</label>
                    <input class="form-control" type="text" name="view_count" id="view_count-field" value="{{ old('view_count', $course_article->view_count ) }}" />
                </div> 
                <div class="form-group">
                	<label for="slug-field">Slug</label>
                	<input class="form-control" type="text" name="slug" id="slug-field" value="{{ old('slug', $course_article->slug ) }}" />
                </div> 
                <div class="form-group">
                    <label for="course_books_id-field">Course_books_id</label>
                    <input class="form-control" type="text" name="course_books_id" id="course_books_id-field" value="{{ old('course_books_id', $course_article->course_books_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for=" courses_section_id-field"> Courses_section_id</label>
                    <input class="form-control" type="text" name=" courses_section_id" id=" courses_section_id-field" value="{{ old(' courses_section_id', $course_article-> courses_section_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $course_article->user_id ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('course_articles.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
