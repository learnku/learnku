@extends('layouts.app')
@section('title', $article->title ? $article->title : '实战教程')

@section('body')
    {{-- 目录侧边栏 --}}
    <div class="ui basic primary  launch right attached fixed button" id="right-menu-btn">
        <i class="content icon"></i>
        <span class="text">Menu</span>
    </div>
    <div class="ui vertical sidebar menu left book-side-menu" style="z-index: 99999;">
        <div class="item lh-2">
            <b>{{ $article->section->book->title }}</b>
        </div>
        @foreach($sections as $section)
            <div class="item">
                <div class="header">
                    {{ $section->title }}
                </div>

                <div class="menu article">
                    @foreach($section->articles as $item)
                        <a class="item {{ active_class(if_route_param('article', $item->id)) }}"
                           href="{{ route('course.articles.show', [$article->section->book->id, $item->id]) }}">
                            {{ $item->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('content')
    <div class="ui centered grid container stackable">
        {{-- 主体 --}}
        <div class="twelve wide column js-computed-height-right">
            <div class="ui segment article-content">
                <div class="extra-padding">
                    <h1>
                        <i class="grey file text outline icon"></i>
                        <span style="line-height: 34px;">{{ $article->title }}</span>
                    </h1>

                    <div class="book-article-meta">
                        <a href="{{ route('course.books.show', $article->section->book->id) }}">
                            <i class="icon book"></i> {{ $article->section->book->title }}
                        </a>

                        <span class="divider">/</span>

                        <span class="relative ">
                            <a class="chapter-title user-has-done-btn" data-act="chapter_sidebar_clicked"
                               href="javascript:void(0);">
                                <i class="icon map signs"></i> {{ $article->section->title }}
                            </a>
                        </span>
                        @auth
                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('Founder'))
                            <span style="font-size: 13px;color: #adb1af;">（
                                <a href="{{ route('course.articles.edit', [$data['book_id'], $article->id]) }}"><i class="icon edit"></i>编辑</a>
                                <span class="divider">|</span>
                                <a class="  top-admin-operation ml-0" href="javascript:;"
                                   data-method="delete"
                                   data-url="{{ route('course.articles.destroy', [$data['book_id'], $article->id]) }}"
                                   style="cursor: pointer;"><i class=" trash icon"></i>删除
                                </a>）
                            </span>
                            @endif
                        @endauth
                    </div>

                    <div class="ui divider"></div>

                    {{-- 文章详情 --}}
                    <div class="ui readme markdown-body content-body fluidbox-content">
                        {{-- 需要付费教程文章 --}}
                        @if($article->policy == '1')
                            {{-- 已付款 --}}
                            @if($article->section->book->order && $article->section->book->order['flag'] == '1')
                                {!! markdownToHtml($article->body, 'markdown') !!}
                            @else
                                {{-- 未付款 --}}
                                {!! markdownToHtml($article->body, 'markdown', 500) !!}
                                <blockquote style="border: dashed 3px #9bacc1;">
                                    <p>为了保证课程的高品质，我们需要对课程进行收费。
                                        <a href="{{ route('course.purchases.index', $article->section->book->id) }}" target="_blank">付费后</a>
                                        才能观看剩余内容。
                                        <a class="ui  label green" href="{{ route('course.purchases.index', $article->section->book->id) }}" target="_blank">
                                            <i class="icon shop"></i> 购买
                                        </a>
                                    </p>
                                </blockquote>
                            @endif
                        @else
                            {{-- 免费教程文章 --}}
                            {!! markdownToHtml($article->body, 'markdown') !!}
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <a class="ui basic button small article-pager-btn pull-left disabled page-prev-btn"
                    data-content="" href="javascript:;">
                    <i class="icon arrow left"></i> 上一篇
                </a>
                <a class="ui basic button small article-pager-btn pull-right popover disabled page-next-btn"
                   data-content=""
                   href="javascript:;">
                    下一篇
                    <i class="icon arrow right"></i>
                </a>
                <div class="clearfix"></div>
            </div>

            {{-- 回复 --}}
            @include('pages.replies._reply_list')
            @include('pages.replies._reply_box', ['input_model'=> \App\Models\CourseArticle::class ])
        </div>

        {{-- 侧边栏 --}}
        <div class="four wide column js-computed-height-left">
            <div class="item header sidebar book-article">
                <div class="ui segment orange text-center">
                    刻意练习，每日精进。
                </div>

                <div class="ui segment">
                    <div class="two ui basic buttons small">
                        <a class="ui labeled icon basic article-pager-btn button left attached disabled page-prev-btn"
                           data-content="" href="javascript:;">
                            <i class="left arrow icon"></i>
                            上一篇
                        </a>
                        <a class="ui right labeled article-pager-btn icon basic button right attached popover disabled page-next-btn"
                           data-content=""
                           href="javascript:;">
                            <i class="right arrow icon"></i>
                            下一篇
                        </a>
                    </div>
                </div>

                <div class="ui segment">

                    <div class="ui three statistics">
                        <div class="ui huge statistic">
                            <div class="value">~</div>
                            <div class="label">点赞</div>
                        </div>
                        <div class="ui huge statistic">
                            <div class="value">{{ $article->view_count }}</div>
                            <div class="label">浏览</div>
                        </div>
                        <a class="ui huge statistic" href="#topics-list">
                            <div class="value">{{ $article->reply_count }}</div>
                            <div class="label">讨论</div>
                        </a>
                    </div>


                    <br>
                </div>
                <div class="ui stackable cards">
                    <div class="ui  card column author-box grid authors-box responsive" style="margin-top: 20px;">

                        <div class="ui fluid hide-on-mobile" style="margin-top: 20px;">
                            <div class="ui teal ribbon label">
                                <i class="star icon"></i> 作者
                            </div>
                        </div>

                        <a href="javascript:;" class="avatar-link authors first">
                            <img class="ui centered circular tiny image"
                                 src="{{ assert_images($article->user->info->image['path']) }}"><span
                                class="author-name">{{ $article->user->name }}</span>
                        </a>
                    </div>
                </div>

                {{-- 文章导航 --}}
                <div class="ui sticky doc toc">
                    <div class="ui card column author-box grid  tocify" id="markdown-tocify"
                         style="max-height: 100%;padding: 22px 4px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- 上一页、下一页 --}}
    <script type="text/javascript">
        let allHref = [];
        $('.book-side-menu').find('a').each(function () {
            allHref.push({
                'href': $(this).attr('href'),
                'title': $.trim($(this).text()),
                'active': $(this).hasClass('active') ? true : false
            });
        });
        let activeIndex = allHref.findIndex(function(item){
            return item.active;
        });
        // 上一页
        let prev = allHref[activeIndex - 1];
        // 下一页
        let next = allHref[activeIndex + 1];

        if(prev){
            $('.page-prev-btn').attr('href', prev.href);
            $('.page-prev-btn').attr('data-content', prev.title);
            $('.page-prev-btn').removeClass('disabled');
        }
        if(next){
            $('.page-next-btn').attr('href', next.href);
            $('.page-next-btn').attr('data-content', next.title);
            $('.page-next-btn').removeClass('disabled');
        }
    </script>

    <script type="text/javascript">
        // 发表回复
        var markdown = new Markdown();
        markdown.init({
            'textarea': {
                'id': 'markdown-editor'
            },
            'interval': false,
            'markdown': {
                status: false,
                toolbar: false,
            },
            'events': {
                change: function (html) {
                    if ($.trim(html) !== '') {
                        $("#preview-box").html(html).fadeIn();
                    } else {
                        $("#preview-box").fadeOut();
                    }
                }
            }
        });
    </script>
    <script type="text/javascript">
        // 删除评论
        LearnkuNew.axiosDeleteForm(function (btn) {
            $(btn).closest('.comment').remove();
        })
    </script>
    <script type="text/javascript">
        var auth = Boolean("{{ Auth::check() }}");
        // 发表评论
        $("#comment-composing-form").submit(function () {
            if (auth) {
                axios({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                }).then((res)=> {
                    Swal.fire({
                        type: 'success',
                        title: '评论发表成功 . . .',
                        text: '请耐心等待管理员审核',
                    });
                    // 重置 markdown
                    window['markdown_markdown-editor'].value('');
                }).catch(function (error) {
                    window.public.axios_catch(error);
                });
            } else {
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
@endsection
