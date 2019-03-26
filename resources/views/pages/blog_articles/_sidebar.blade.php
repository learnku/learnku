<div class="four wide column pull-left sidebar clear" style="padding-right: 0px;">
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
            <div class="extra content readmore" style="padding-bottom: 18px; max-height: none;">
                @foreach($common['blogInfo']['categories'] as $item)
                <a class="ui label basic" href="{{ route('blog.categories.show', $item['id']) }}">
                    {{ $item['name'] }}
                    <div class="detail">{{ $item['post_count'] }}</div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- 博客标签 --}}
        {{--<div class="ui card tag-active-user-card blog-tags responsive">
            <div class="content">
                <span class="">博客标签</span>
            </div>
            <div class="extra content readmore" style="padding-bottom: 18px; max-height: none;">
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/api_40">
                    api
                    <div class="detail">1</div>
                </a>
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/artisan_549">
                    artisan
                    <div class="detail">3</div>
                </a>
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/faker_589">
                    faker
                    <div class="detail">2</div>
                </a>
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/toolbar_3904">
                    toolbar
                    <div class="detail">8</div>
                </a>
                <a class="ui label basic" href="https://learnku.com/blog/liguanjie8/tags/webmaster-tools_Dc_49134">
                    站长工具
                    <div class="detail">1</div>
                </a>
            </div>
        </div>--}}

        {{-- 最新 热门文章 --}}
        <div class="ui card tag-active-user-card popular-card responsive" style="font-size: 13px;">
            <div class="ui secondary pointing menu" style="margin-bottom: 5px;border-bottom: 2px solid rgba(34, 36, 38, 0.1);">
                <a class="item active" data-tab="first">最新文章</a>
                <a class="item" data-tab="second">最受欢迎</a>
            </div>
            <div class="ui bottom attached tab active" data-tab="first">

                <div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;margin-bottom: 5px;">
                    <a class="item" href="https://learnku.com/articles/25001">
                        <span class="ui label tiny">2周前 </span>
                        HTML 与 Markdown 互相转换
                    </a>
                    <a class="item" href="https://learnku.com/articles/24877">
                        <span class="ui label tiny">3周前 </span>
                        test
                    </a>
                    <a class="item" href="https://learnku.com/articles/24169">
                        <span class="ui label tiny">1个月前 </span>
                        Laravel - 验证码 - API
                    </a>
                    <a class="item" href="https://learnku.com/articles/24063">
                        <span class="ui label tiny">1个月前 </span>
                        Laravel 短信发送组件 - easy-sms
                    </a>
                    <a class="item" href="https://learnku.com/articles/24055">
                        <span class="ui label tiny">1个月前 </span>
                        Laravel 安装 DingoAPI
                    </a>
                </div>
            </div>
            <div class="ui bottom attached tab" data-tab="second">
                <div class="ui middle aligned divided  list" style="padding: 0px 15px;margin-top: 0px;">
                    <a class="item" href="https://learnku.com/articles/22588">
                        <span class="ui label tiny"><i class="thumbs up icon"></i> 8 </span>
                        XSS 安全漏洞 - HTMLPurifier
                    </a>
                    <a class="item" href="https://learnku.com/articles/22514">
                        <span class="ui label tiny"><i class="thumbs up icon"></i> 3 </span>
                        Laravel Artisan 命令大全
                    </a>
                    <a class="item" href="https://learnku.com/articles/22539">
                        <span class="ui label tiny"><i class="thumbs up icon"></i> 1 </span>
                        Laravel 开发者工具类 - Laravel-debugbar。
                    </a>
                    <a class="item" href="https://learnku.com/articles/22548">
                        <span class="ui label tiny"><i class="thumbs up icon"></i> 1 </span>
                        Laravel - 获取当前路由的 `active` class 样式
                    </a>
                    <a class="item" href="https://learnku.com/articles/22300">
                        <span class="ui label tiny"><i class="thumbs up icon"></i> 1 </span>
                        Laravel Artisan 命令工具使用技巧
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
