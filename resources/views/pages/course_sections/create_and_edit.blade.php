@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          CourseSection /
          @if($course_section->id)
            Edit #{{ $course_section->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($course_section->id)
          <form action="{{ route('course_sections.update', $course_section->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('course_sections.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $course_section->title ) }}" />
                </div> 
                <div class="form-group">
                    <label for="course_books_id-field">Course_books_id</label>
                    <input class="form-control" type="text" name="course_books_id" id="course_books_id-field" value="{{ old('course_books_id', $course_section->course_books_id ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('course_sections.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
