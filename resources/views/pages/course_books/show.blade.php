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
                                        <a class="ui button primary go-start-read" href="javascript:;"><i class="icon game"></i>开始阅读</a>
                                        @if(Auth()->user()->hasRole('Founder'))
                                        <a class="ui button black" href="">
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
                            文章列表
                        </a>
                    </div>
                    <br>
                    <ol class=" sorted_table tree " data-chapterid="0" data-filetype="chapter">
                        @foreach($sections as $section)
                        <li class="item" data-itemid="461" data-filetype="chapter" data-chapterid="461">
                            <i class="blue folder icon"></i>
                            {{ $section->title }}
                            <ol data-chapterid="461" class="chapter-container">
                                @foreach($section->articles as $article)
                                <li class="item" data-itemid="2517" data-filetype="file" data-chapterid="461">
                                    <i class="grey file text outline icon"></i>
                                    <a href="{{ route('course.articles.show', [$book->id, $article->id]) }}" class="">
                                        {{ $article->title }}
                                        <span class="ui left  green basic label">免费</span>
                                    </a>
                                </li>
                                @endforeach
                            </ol>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- 开始阅读 --}}
    <script type="text/javascript">
        $('.go-start-read').attr('href', $('ol.sorted_table a').eq(0).attr('href'))
    </script>
@endsection
