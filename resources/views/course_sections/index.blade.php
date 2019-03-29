@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          CourseSection
          <a class="btn btn-success float-xs-right" href="{{ route('course_sections.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($course_sections->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>Title</th> <th>Course_books_id</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($course_sections as $course_section)
              <tr>
                <td class="text-xs-center"><strong>{{$course_section->id}}</strong></td>

                <td>{{$course_section->title}}</td> <td>{{$course_section->course_books_id}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('course_sections.show', $course_section->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('course_sections.edit', $course_section->id) }}">
                    E
                  </a>

                  <form action="{{ route('course_sections.destroy', $course_section->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $course_sections->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
