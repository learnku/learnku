@extends('layouts.app')
@section('title', isset($category) ? $category->name : '博文列表')

@section('content')
    <div class="ui centered grid container main stackable blog" style="">
        <div class="twelve wide column pull-right main" style="margin-bottom: 3rem;">
            <div class="ui segment article-content">
                <div class="extra-padding">
                    <h1>
                        <i class="icon newspaper"></i>
                        @if (isset($category))
                            {{ $category->name }} ：{{ $category->description }}
                        @else
                            所有文章
                        @endif
                        <div class="ui secondary menu pull-right small" style="margin-top: -4px;">
                            <div class="ui item" style="font-size:13px;padding: 0px 4px;color: #777;">
                                文章排序：
                            </div>
                            {{--<a class="ui item popover {{ active_class( ! if_query('order', 'vote')) }}"
                               data-content="按照时间排序"
                               href="{{ Request::url() }}?order=recent" role="button">时间</a>
                            <a class="ui item  popover {{ active_class(if_query('order', 'vote')) }}"
                               data-content="按照投票排序"
                               href="{{ Request::url() }}?order=vote" role="button">投票</a>--}}
                        </div>

                    </h1>
                    <div class="ui divider"></div>
                    @include('pages.blog_articles._article_list')
                </div>

                {{-- 分页 --}}
                {{ $blog_articles->links() }}
            </div>
        </div>

        @include('pages.blog_articles._sidebar', ['isArticleList'=> true])
        <div class="clearfix"></div>
    </div>

@endsection
