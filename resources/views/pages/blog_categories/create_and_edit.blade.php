@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          BlogCategory /
          @if($blog_category->id)
            Edit #{{ $blog_category->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($blog_category->id)
          <form action="{{ route('blog.categories.update', $blog_category->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('blog.categories.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="name-field">Name</label>
                	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $blog_category->name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="description-field">Description</label>
                	<textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $blog_category->description ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="post_count-field">Post_count</label>
                    <input class="form-control" type="text" name="post_count" id="post_count-field" value="{{ old('post_count', $blog_category->post_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $blog_category->user_id ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('blog.categories.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
