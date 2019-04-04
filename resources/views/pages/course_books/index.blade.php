@extends('layouts.app')
@section('title', '实战教程')

@section('content')
    <div class="ui centered grid container stackable" style="margin-bottom: 80px;min-height:380px">
        <div class="twelve wide column">
            <div class="ui segment text-center">
                实战系列课程，每个课程对应一个实战项目，助你从小工成就大师
            </div>
            @auth
                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Founder'))
                <div class="ui segment text-center">
                    <a href="{{ route('course.books.create') }}">新建教程</a>
                </div>
                @endif
            @endauth

            @if($books->count())
                @foreach($books as $book)
                <div class="ui segment ">
                    <div class="extra content tag-active-user-card">
                        <div class="ui middle aligned divided list " style="padding:12px">
                            <div class="ui items">

                                <div class="item">
                                    <a class="image" href="{{ route('course.books.show', $book->id) }}">

                                        <img class="ui image image-shadow lazy" data-original="{{ assert_images($book->image['path']) }}"></a>
                                    <div class="content">
                                        <div class="header" style="width:100%">
                                            <a href="{{ route('course.books.show', $book->id) }}" class="ui text black">
                                                {{ $book->title }}
                                            </a>
                                        </div>

                                        {!! markdownToHtml($book->excerpt) !!}

                                        <div class="extra">
                                            <a class="ui button primary" href="{{ route('course.books.show', $book->id) }}">查看课程</a>

                                            @auth
                                                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Founder'))
                                                    <a class="ui button black" href="{{ route('course.books.edit', $book->id) }}">编辑</a>
                                                    <form action="{{ route('course.books.destroy', $book->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('你确定要删除吗 ?');">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="_method" value="DELETE">

                                                        <button type="submit" class="ui button grey">删除 </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {!! $books->render() !!}
            @else
                暂无分类数据 ~
            @endif
        </div>

        <div class="four wide column">
            暂无数据 ~
        </div>
    </div>
@endsection
