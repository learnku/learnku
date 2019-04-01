@extends('layouts.app')

@section('content')
    <div class="ui centered grid container books-page stackable rm-link-color">
        <div class="fourteen wide column">
            <div class="ui segment">
                <div class="content extra-padding">
                    <br><div class="book header">
                        <div class="ui items">
                            <div class="item">
                                <div class="image">
                                    <img class="ui image image-shadow lazy" data-original="">
                                </div>
                                <div class="content">
                                    <div class="header" style="width:100%">
                                        {{ $book->title }}
                                    </div>

                                    <div class="description">
                                        <div class="meta" style="line-height:24px">
                                            <a href="javascript:;">
                                                <i class="icon clock"></i> 更新于 <span title="{{ $book->updated_at }}">{{$book->updated_at}}</span>
                                            </a>
                                        </div>
                                        {{$book->excerpt}}
                                    </div>

                                    <div class="extra">
                                        @if(Auth()->user()->hasRole('Founder'))
                                            <a class="ui button black" href="{{ route('course.sections.create', $book->id) }}">
                                                新建章节
                                            </a>
                                            <a class="ui button black" href="{{ route('course.articles.create', $book->id) }}">
                                                新建教程文章
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="ui  attached tabular menu" id="topics">
                        <a class="item active" href="javascript:;">
                            <i class="grey content icon"></i>
                            章节列表
                        </a>
                    </div>
                    <br>
                    <ol class=" sorted_table tree " data-chapterid="0" data-filetype="chapter">
                        @foreach($sections as $section)
                            <li class="item" data-itemid="461" data-filetype="chapter" data-chapterid="461">
                                <i class="blue folder icon"></i>
                                {{ $section->title }}
                                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Founder'))
                                    <span style="font-size: 13px;color: #adb1af;">（
                                        <a href="{{ route('course.sections.edit', [$book->id, $section->id]) }}"><i class="icon edit"></i>编辑</a>
                                        <span class="divider">|</span>
                                        <a class="top-admin-operation ml-0" href="javascript:;"
                                           data-method="delete"
                                           data-url="{{ route('course.sections.destroy', [$book->id, $section->id]) }}"
                                           style="cursor: pointer;"><i class=" trash icon"></i>删除
                                        </a>）
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ol>

                    {!! $sections->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
