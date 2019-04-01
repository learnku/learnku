@extends('layouts.app')

@section('content')
    <div class="ui centered grid container stackable">
        <div class="sixteen wide column ">
            <h1><a href="{{ route('course.books.create') }}">新建教程书籍</a></h1>
            @if($books->count())
                <table class="ui celled table selectable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>简介</th>
                        <th>用户id</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{$book->id}}</td>
                            <td><a href="{{ route('course.books.show', $book->id) }}">{{$book->title}}</a></td>
                            <td>{{$book->excerpt}}</td>
                            <td>{{$book->user_id}}</td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{ route('course.books.edit', $book->id) }}">
                                    编辑
                                </a>
                                <form action="{{ route('course.books.destroy', $book->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('你确定要删除吗 ?');">
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
                            {!! $books->render() !!}
                        </th>
                    </tr></tfoot>
                </table>
            @else
                暂无分类数据 ~
            @endif
        </div>
    </div>
@endsection
