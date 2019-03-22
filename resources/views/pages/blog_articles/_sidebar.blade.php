<div class="four wide column pull-left sidebar clear" style="padding-right: 0px;">
    <div class="item header blog-article sidebar" style="height:auto !important;">
        <div>
            {{-- 个人信息 --}}
            @if(!isset($isArticleList))
            <div class="ui card responsive" style="padding: 6px;">
                <div class="content">
                    <a href="{{ route('users.show', $article->user_id)}}" class="rm-link-color">
                        <img class="ui circular  image right floated image-44" src="{{ $article->user->avatar }}"></a>

                    <div class="header" style="line-height: 28px;margin-bottom: 5px;">
                        <a href="{{ route('users.show', $article->user_id) }}" class="rm-link-color" style="font-weight: bold;font-size: 15px;">
                            {{ $article->user->name }}
                        </a>
                    </div>

                    <div class="meta" style="font-size: 13px;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;">{{ $article->user->introduction }}</div>
                </div>

                <div class="statistics" style="border-top: 1px solid rgba(0, 0, 0, 0.05);border-bottom: 1px solid rgba(0, 0, 0, 0.05);padding-bottom: 15px;padding-top: 10px;">
                    <div class="ui four statistics">
                        <div class="statistic ui popover" data-content="博客文章总数">
                            <div class="label" style="font-size: 1em!important;font-weight: normal;">
                                文章
                            </div>
                            <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                {{ $article->user->articles->count() }}
                            </div>
                        </div>

                        <div class="statistic ui popover" data-content="关注作者的用户数">
                            <div class="label" style="font-size: 1em!important;font-weight: normal;">
                                粉丝
                            </div>
                            <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                ~
                            </div>
                        </div>

                        <div class="statistic ui popover" data-content="收到了 ~ 个点赞">
                            <div class="label" style="font-size: 1em!important;font-weight: normal;">
                                喜欢
                            </div>
                            <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                ~
                            </div>
                        </div>

                        <div class="statistic ui popover" data-content="所有文章被收藏了 ~ 次">
                            <div class="label" style="font-size: 1em!important;font-weight: normal;">
                                收藏
                            </div>
                            <div class="value" style="font-size: 1em!important;font-weight: bold;">
                                ~
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="ui two column grid text-center" style="padding: 15px">
                    <div class="column ui popover" data-content="博客总访问量排行第 ~ 位 ">
                        排名：~
                    </div>
                    <div class="column ui popover" data-content="博客总访问量 ~（每日更新）" style="padding-left:0px">
                        访问：~
                    </div>
                </div>

            </div>
            @endif

            {{-- 撰写文章 --}}
            <a href="{{ route('blog.articles.create') }}" class="ui basic green button fluid" style="
              background: white!important;">
                <i class="icon paint brush"></i>
                撰写文章
            </a>

            {{-- user 博客首页 --}}
            @if(!isset($isArticleList))
            <a href="{{ route('users.show', $article->user_id) }}" class="ui basic button fluid" style="
              background: white!important;margin-top:18px">
                <i class="icon newspaper"></i>
                Ta 的博客首页
            </a>
            @endif

            {{-- 文章归档 --}}
            {{--<div class="ui card tag-active-user-card popular-card responsive">
                <div class="content">
                    <span class="">文章归档</span>

                    <a href="https://learnku.com/blog/liguanjie8" class="rm-link-color pull-right ui popover" style="font-size: 15px;margin-right: 8px;" data-content="所有文章">
                        <i class="icon newspaper"></i>
                    </a>
                </div>
                <div class="extra content ">
                    <div class="ui list readmore" style="padding: 8px; max-height: none;">
                        <a class="item" href="https://learnku.com/blog/liguanjie8/archive/2019-2" style="line-height: 22px;">
                            <span class=" pull-right" style="color:inherit">4 篇</span>
                            2019 年 2 月
                        </a>
                    </div>
                </div>
            </div>--}}

            {{-- 最新文章 . 最受欢迎 --}}
            <div class="ui card tag-active-user-card popular-card responsive" style="font-size: 13px;">
                <div class="ui secondary pointing menu" style="margin-bottom: 5px;border-bottom: 2px solid rgba(34, 36, 38, 0.1);">
                    <a class="item active" data-tab="first">最新文章</a>
                    <a class="item" data-tab="second">最受欢迎</a>
                </div>
                <div class="ui bottom attached tab active" data-tab="first">

                    {{--<div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;margin-bottom: 5px;">
                        @foreach(\App\Models\BlogArticle::orderBy('created_at', 'desc')->limit(5)->get() as $item)
                        <a class="item" href="{{ route('articles.show', $item->id) }}">
                            <span class="ui label tiny">{{ $item->created_at->diffForHumans() }} </span>
                            {{ $item->title }}
                        </a>
                        @endforeach
                    </div>--}}
                </div>
                <div class="ui bottom attached tab" data-tab="second">
                    {{--<div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;">
                        @foreach(\App\Models\Article::orderBy('view_count', 'desc')->limit(5)->get() as $item)
                            <a class="item" href="{{ route('articles.show', $item->id) }}">
                                <span class="ui label tiny">{{ $item->created_at->diffForHumans() }} </span>
                                {{ $item->title }}
                            </a>
                        @endforeach
                    </div>--}}
                </div>

            </div>

            {{-- 博客标签 --}}
            <div class="ui card tag-active-user-card blog-tags responsive">
                <div class="content">
                    <span class="">博客标签</span>
                </div>
                <div class="extra content readmore" style="padding-bottom: 18px; max-height: none;">
                    @if(!isset($isArticleList))
                        @foreach($article->user->tags as $item)
                            <a class="ui label basic"
                               href="{{ route('users.tags.show', ['user'=> $article->user_id, 'tag'=> $item->id]) }}">{{ $item->name }}</a>
                        @endforeach
                    @else
                        {{--@foreach( \App\Models\Tag::all() as $item )
                            <a class="ui label basic"
                               href="{{ route('tags.show', ['tag'=> $item->id]) }}">{{ $item->name }}</a>
                        @endforeach--}}
                    @endif
                </div>
            </div>

            {{-- 广告 --}}
            <div class="ui card responsive" style="background-color: transparent;padding: 0;margin-top: 2px;">
                <div class="content" style="padding: 0;">
                    <a class="" href="https://www.aliyun.com/acts/product-section-2019/new-users?userCode=yu1zlfjb" target="_blank" style="display: block;border-top: 1px solid #d3e0e9;border-bottom: 1px solid #d3e0e9;">
                        <img src="/images/banner/aliyun01.png" class="ui popover" data-variation="inverted" data-content="【阿里云】【开年HI购季】爆款云产品5折" width="100%">
                    </a>
                </div>
            </div>

            {{-- 加入群聊 --}}
            <div class="ui card responsive" style="background-color: transparent;padding: 0;margin-top: 2px;">
                <div class="content" style="padding: 0;">
                    <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=d0ae1ecab906fda90348e051314ac221d0386ead9607b698d7e5b60269b56080" style="display: block;border-top: 1px solid #d3e0e9;border-bottom: 1px solid #d3e0e9;">
                        <img border="0" src="/images/public/qq.png" alt="web学习" title="web学习" class="ui popover" data-variation="inverted" data-content="加入群聊" width="100%">
                    </a>
                </div>
            </div>

            {{-- 文章导航 --}}
            @if(!isset($isArticleList))
            <div class="ui sticky doc toc">
                <div class="ui card column author-box grid  tocify" id="markdown-tocify"></div>
            </div>
            @endif
        </div>
    </div>
</div>
