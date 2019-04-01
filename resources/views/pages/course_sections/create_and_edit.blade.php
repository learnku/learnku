@extends('layouts.app')

@section('content')
    @include('shared._error')

    <div class="ui centered grid container stackable">
        <div class="sixteen wide column">
            <div class="ui segment">
                <a class="ui right corner label compose-help" href="javascript:;">
                    <i class="info icon"></i>
                </a>

                <div class="content extra-padding">
                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        @if($section->id)
                            <i class="icon paint brush"></i>编辑章节 {{ $section->title }}
                        @else
                            <i class="icon paint brush"></i>新建章节
                        @endif
                    </div>

                    @if($section->id)
                        <form id="article-update-form"
                              class="ui form"
                              style="min-height: 50px;"
                              action="{{ route('course.sections.update', [$book->id, $section->id]) }}" method="POST"
                              accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                    @else
                        <form id="article-create-form"
                              style="min-height: 50px;"
                              class="ui form"
                              action="{{ route('course.sections.store', $book->id) }}"
                              method="POST" accept-charset="UTF-8">
                    @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="field">
                                <label>章节
                                    <a target="_blank" href="{{ route('course.sections.index', $book->id) }}">管理章节</a>
                                </label>
                                <input class="form-control" type="text" name="title"
                                       id="title-field" value="{{ old('title', $section->title ) }}"
                                       placeholder="请填写标题" required="">
                            </div>


                            <div class="ui message">
                                <button type="submit" class="ui button primary publish-btn loading-on-clicked" id="">
                                    <i class="icon send"></i>
                                    提交
                                </button>
                            </div>

                        </form>

                </div>

            </div>
        </div>
    </div>

@endsection
