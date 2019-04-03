@extends('layouts.app')
@section('title', isset($category) ? $category->name : '博文列表')

@section('content')
    <div class="ui centered grid container main stackable blog" style="">
        <div class="twelve wide column pull-right main" style="margin-bottom: 3rem;">
            <div class="ui segment article-content">
                <div class="extra-padding">
                    @if(if_route('search.index'))
                        <h1 class="fs-large">
                            <i class="icon search"></i> 为您找到 {{ $data['search']['article_all_num'] }} 条关于 <code class="search-keyword"> {{ $data['search']['q'] }} </code> 的内容
                            <div class="pull-right" style="margin-top: -5px;margin-right: 0px;">
                                <div class="ui basic simple icon dropdown button small">
                                    <i class="list icon"></i>
                                    <span class="text">排序：{{ $data['search']['order_select'] }}</span>
                                    <div class="menu">
                                        <h3 class="header fs-normal">
                                            请选择排序方式
                                        </h3>
                                        <div class="ui divider"></div>
                                        @foreach($data['search']['order'] as $item)
                                        <a class="item" href="{{ $item['href'] }}">
                                            <i class="icon {{ $item['icon'] }}"></i>{{ $item['name'] }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </h1>
                    @else
                        <h1>
                            <i class="icon newspaper"></i>
                            @if (isset($category))
                                分类：<code class="search-keyword">{{ $category->name }} </code>
                                 {{--{{ $category->description }}--}}
                            @elseif (isset($tag))
                                标签：<code class="search-keyword">{{ $tag->name }} </code>
                            @else
                                所有文章
                            @endif
                            <div class="ui secondary menu pull-right small" style="margin-top: -4px;">
                                <div class="ui item" style="font-size:13px;padding: 0px 4px;color: #777;">
                                    文章排序：
                                </div>
                                <a class="ui item popover {{ active_class( ! if_query('order', 'vote')) }}"
                                   data-content="按照时间排序"
                                   href="{{ Request::url() }}?order=recent" role="button">时间</a>
                                <a class="ui item  popover {{ active_class(if_query('order', 'vote')) }}"
                                   data-content="按照投票排序"
                                   href="{{ Request::url() }}?order=vote" role="button">投票</a>
                            </div>
                        </h1>
                    @endif
                    <div class="ui divider"></div>
                    @include('pages.blog_articles._article_list')
                </div>

                {{-- 分页 --}}
                {{ $blog_articles->appends(Request::except('page', '_pjax'))->render() }}
            </div>
        </div>

        @include('pages.blog_articles._sidebar', ['isArticleList'=> true])
        <div class="clearfix"></div>
    </div>

@endsection
