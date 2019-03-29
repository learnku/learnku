@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>CourseBook / Show #{{ $course_book->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('course_books.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('course_books.edit', $course_book->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>
Title</label>
<p>
	{{ $course_book->
title }}
</p> <label>Excerpt</label>
<p>
	{{ $course_book->excerpt }}
</p> <label>User_id</label>
<p>
	{{ $course_book->user_id }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
