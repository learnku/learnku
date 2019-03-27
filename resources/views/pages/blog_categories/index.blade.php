@extends('layouts.app')

@section('content')
    <div class="ui centered grid container stackable">
        <div class="sixteen wide column ">
            <h1><a href="{{ route('blog.categories.create') }}">新建分类</a></h1>
            @if($categories->count())
            {{-- inverted --}}
            <table class="ui celled table selectable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>分类名称</th>
                    <th>分类描述</th>
                    <th>上级分类</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td><a href="{{ route('blog.categories.show', $category->id) }}">{{$category->name}}</a></td>
                    <td>{{$category->description}}</td>
                    <td>{{$category->cascade}}</td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="{{ route('blog.categories.edit', $category->id) }}">
                            编辑
                        </a>
                        <form action="{{ route('blog.categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('你确定要删除吗 ?');">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">

                            <button type="submit" class="btn btn-sm btn-danger">删除 </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr><th colspan="5">
                        {!! $categories->render() !!}
                    </th>
                </tr></tfoot>
            </table>
            @else
                暂无分类数据 ~
            @endif
        </div>
    </div>
@endsection
