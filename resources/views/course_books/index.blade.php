@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          CourseBook
          <a class="btn btn-success float-xs-right" href="{{ route('course_books.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($course_books->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>
Title</th> <th>Excerpt</th> <th>User_id</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($course_books as $course_book)
              <tr>
                <td class="text-xs-center"><strong>{{$course_book->id}}</strong></td>

                <td>{{$course_book->
title}}</td> <td>{{$course_book->excerpt}}</td> <td>{{$course_book->user_id}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('course_books.show', $course_book->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('course_books.edit', $course_book->id) }}">
                    E
                  </a>

                  <form action="{{ route('course_books.destroy', $course_book->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $course_books->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
