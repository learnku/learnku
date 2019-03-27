{{--<div class="four wide column" style="padding-right: 0px;">
    <div class="item header book-article" style="height:auto !important;">--}}
<div class="js-computed-height-left four wide column pull-left sidebar clear" style="padding-right: 0px;">
    <div class="item header blog-article sidebar" style="height:auto !important;">
        <div class="ui segment orange text-center" style="padding: 25px;">
            刻意记录，每日精进。
        </div>

        {{-- 信息汇总 --}}
        <div class="ui segment">
            <div class="ui three statistics">
                <div class="ui huge statistic">
                    <div class="value">{{ $common['blogInfo']['collect']['article_num'] }}</div>
                    <div class="label">文章</div>
                </div>
                <div class="ui huge statistic">
                    <div class="value">{{ $common['blogInfo']['collect']['view_count_num'] }} </div>
                    <div class="label">浏览</div>
                </div>
                <div class="ui huge statistic">
                    <div class="value">{{ $common['blogInfo']['collect']['reply_count_num'] }} </div>
                    <div class="label">讨论</div>
                </div>
            </div>
        </div>

        {{-- 文章归档 --}}
        <div class="ui card tag-active-user-card popular-card responsive">
            <div class="content">
                <span class="">文章归档</span>

                <a href="{{ route('blog.articles.index') }}" class="rm-link-color pull-right ui popover" style="font-size: 15px;margin-right: 8px;" data-content="所有文章">
                    <i class="icon newspaper"></i>
                </a>
            </div>
            <div class="extra content ">
                <div class="ui list readmore" style="padding: 8px; max-height: none;">
                    @foreach($common['blogInfo']['groupTime'] as $item)
                    <a class="item" href="" style="line-height: 22px;">
                        <span class=" pull-right" style="color:inherit">{{ $item['num'] }} 篇</span>
                        {{ $item['name'] }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 个人分类 --}}
        <div class="ui card tag-active-user-card blog-tags responsive">
            <div class="content">
                <span class="">个人分类</span>
            </div>
            <div class="extra content">
                <div class="ui list">
                    @foreach($common['blogInfo']['categories'] as $item)
                    <div class="item">
                        <i class="folder icon"></i>
                        <div class="content">
                            <a class="item description" href="{{ route('blog.categories.show', $item['main']['id']) }}">
                                <span class=" pull-right" style="color:inherit">{{ $item['main']['post_count'] }} 篇</span>
                                {{ $item['main']['name'] }}
                            </a>
                            <div class="list">
                                @foreach($item['items'] as $val)
                                <div class="item flex">
                                    <i class="file icon"></i>
                                    <div class="content">
                                        <a class="item description" href="{{ route('blog.categories.show', $val['id']) }}">
                                            <span class="pull-right" style="color:inherit;">{{ $val['post_count'] }} 篇</span>
                                            {{ $val['name'] }}
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 博客标签 --}}
        <div class="ui card tag-active-user-card blog-tags responsive">
            <div class="content">
                <span class="">博客标签</span>
            </div>
            <div class="extra content readmore" style="padding-bottom: 18px; max-height: none;">
                @foreach($common['blogInfo']['tags'] as $item)
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/api_40">
                    {{ $item->name }}
                    <div class="detail">{{ $item->count_num }}</div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- 最新 热门文章 --}}
        <div class="ui card tag-active-user-card popular-card responsive" style="font-size: 13px;">
            <div class="ui secondary pointing menu" style="margin-bottom: 5px;border-bottom: 2px solid rgba(34, 36, 38, 0.1);">
                <a class="item active" data-tab="first">最新文章</a>
                <a class="item" data-tab="second">最受欢迎</a>
            </div>
            <div class="ui bottom attached tab active" data-tab="first">

                <div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;margin-bottom: 5px;">
                    @foreach( $common['blogInfo']['articles_news'] as $item )
                    <a class="item" href="{{ route('blog.articles.show', $item['id']) }}">
                        {{--<span class="ui label tiny">{{ $item['created_at'] }} </span>--}}
                        {{ $item['title'] }}
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="ui bottom attached tab" data-tab="second">
                <div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;">
                    @foreach( $common['blogInfo']['articles_hots'] as $item )
                    <a class="item" href="{{ route('blog.articles.show', $item['id']) }}">
                        {{--<span class="ui label tiny"><i class="thumbs up icon"></i> {{ $item['created_at'] }} </span>--}}
                        {{ $item['title'] }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- 文章导航 --}}
        @if(if_route('blog.articles.show'))
        <div class="ui sticky doc toc">
            <div class="ui card column author-box grid  tocify" id="markdown-tocify"
                 style="max-height: 100%;padding: 22px 4px;"></div>
        </div>
        @endif
    </div>
</div>
