@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>BlogCategory / Show #{{ $blog_category->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('blog.categories.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('blog.categories.edit', $blog_category->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>Name</label>
<p>
	{{ $blog_category->name }}
</p> <label>Description</label>
<p>
	{{ $blog_category->description }}
</p> <label>Post_count</label>
<p>
	{{ $blog_category->post_count }}
</p> <label>User_id</label>
<p>
	{{ $blog_category->user_id }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection
