@extends('layouts.app')
@section('title', isset($article->title) ? $article->title : '博文')

@section('style')
    <style type="text/css">
        .blog.grid.container.main {
            display: block;
        }
        .blog.grid.container.main .sidebar {
            font-size: 14px;
            padding-right:6px;
        }
        .ui.top.menu {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('jquery')
    @include('common.markdown_view')
@endsection

@section('content')
    <div class="ui centered grid container main stackable blog" style="">
        <div class="twelve wide column pull-right main main-column">
            {{-- 文章 --}}
            <div class="ui segment article-content" style="min-height: 40vh;">
                {{-- 右侧工具条 --}}
                <div class="right ui rail hide-on-mobile" style="left: 96%; top: 0px; width: 10px; min-height: 292px; height: 4017px;">

                    <div class="ui sticky topic-operation" style="left: 1557.69px;">
                        <div class="ui vertical icon menu border-0">
                            <a class="item text-mute ui action topic-vote popover rm-link-color text-mute" data-position="left center" id="topic-vote-24169" data-id="24169" href="javascript:;" data-html="                    点赞
                ">
                                <i class="thumbs up icon fs-large "></i>
                                <span class="count vote-count fs-small mt-2 display-inline-block">1</span>
                            </a>

                            <a class="item text-mute ui action collect popover rm-link-color text-mute" data-position="left center" data-id="24169" href="javascript:;" data-html="                    收藏
                ">
                                <i class="heart icon fs-large "></i>
                            </a>

                            <a class="item text-mute ui action  popover rm-link-color text-mute" data-position="left center" data-id="24169" href="#replies" onclick="scrollToAnchor('replies')" title="评论">
                                <i class="comments icon fs-large"></i>
                                <span class="fs-small mt-2 display-inline-block">0</span>
                            </a>

                            <a class="popover item text-mute ui attend-topic is-sticker" data-position="left center" href="javascript:void(0);" data-url="https://learnku.com/attentions/24169" data-id="24169" data-html="                    关注以获取本文最新动态
                ">
                                <div class="top aligned content">
                                    <i class="icon fs-large eye "></i>
                                </div>
                            </a>


                            <a class="item text-mute ui popover report-modal" data-position="left center" data-toggle="modal" data-target="#reportModal" data-contentid="24169" href="javascript:void(0)" data-contenttype="App\Models\Topic" data-typename="话题" data-content="举报违规内容，共建品质社区">
                                <div class="top aligned content">
                                    <i class="icon fs-large flag checkered"></i>
                                </div>
                            </a>

                            <a class="item ui   popover rm-link-color text-mute" data-position="left center" href="#topnav" onclick="scrollToAnchor('topnav')" title="返回顶部">
                                <i class="angle double up icon fs-large fw-bold"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 博文 --}}
                <div class="extra-padding" style="padding-bottom:4px">
                    {{-- 标题 --}}
                    <h1 style="margin-bottom: 15px;">
                        <span style="line-height: 34px;">{{ $article->title }}</span>
                    </h1>

                    {{-- 信息工具条 --}}
                    <div class="book-article-meta" style="margin-bottom: 10px;">
                        <a class="" data-inverted="" data-tooltip="{{ $article->created_at }}">
                            创建于  <span title="{{ $article->created_at }}">{{ $article->created_at->diffForHumans() }}</span>
                        </a>

                        <span class="divider">/</span>
                        <a>阅读数 {{ $article->view_count }}</a>

                        <span class="divider">/</span>
                        <a>评论数 {{ $article->reply_count }}</a>

                        <span class="divider">/</span>
                        <a class="" data-inverted="" data-tooltip="2019-02-15 17:37:49">{{ $article->updated_at->diffForHumans() }}</a>

                        @can('update', $article)
                            <span style="font-size: 13px;color: #adb1af;">
                            （
                            <a href="{{ route('blog.articles.edit', $article->id) }}"><i class="icon edit"></i>编辑</a>
                            <span class="divider">|</span>
                            <a class="top-admin-operation ml-0"
                               href="javascript:;"
                               data-method="delete"
                               data-url="{{ route('blog.articles.destroy', $article->id) }}" style="cursor: pointer;">
                                <i class=" trash icon"></i>删除
                                {{--<form action="{{ route('blog.articles.destroy', $article->id) }}" method="POST" style="display:none">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>--}}
                            </a>
                            ）
                        </span>
                        @endcan
                    </div>

                    {{-- 分割线 --}}
                    <div class="ui divider"></div>

                    {{-- 文章详情 --}}
                    <div class="ui readme markdown-body content-body article-content fluidbox-content">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>

            {{-- 回复 --}}
            {{--@include('pages.blog_articles._reply_list')--}}
            {{--@include('pages.blog_articles._reply_box')--}}
            {{--@includeWhen(Auth::check(), 'pages.articles._reply_box')--}}
        </div>

        @include('pages.blog_articles._sidebar')
    </div>
@endsection
