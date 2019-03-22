@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>
          BlogCategory
          <a class="btn btn-success float-xs-right" href="{{ route('blog.categories.create') }}">Create</a>
        </h1>
      </div>

      <div class="card-body">
        @if($blog_categories->count())
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-xs-center">#</th>
                <th>Name</th> <th>Description</th> <th>Post_count</th> <th>User_id</th>
                <th class="text-xs-right">OPTIONS</th>
              </tr>
            </thead>

            <tbody>
              @foreach($blog_categories as $blog_category)
              <tr>
                <td class="text-xs-center"><strong>{{$blog_category->id}}</strong></td>

                <td>{{$blog_category->name}}</td> <td>{{$blog_category->description}}</td> <td>{{$blog_category->post_count}}</td> <td>{{$blog_category->user_id}}</td>

                <td class="text-xs-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('blog.categories.show', $blog_category->id) }}">
                    V
                  </a>

                  <a class="btn btn-sm btn-warning" href="{{ route('blog.categories.edit', $blog_category->id) }}">
                    E
                  </a>

                  <form action="{{ route('blog.categories.destroy', $blog_category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-sm btn-danger">D </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $blog_categories->render() !!}
        @else
          <h3 class="text-xs-center alert alert-info">Empty!</h3>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
