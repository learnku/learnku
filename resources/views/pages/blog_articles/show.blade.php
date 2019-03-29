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
        .tocify-header{
            padding: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="ui centered grid container main stackable blog">
        <div class="js-computed-height-right twelve wide column pull-right main main-column">
            {{-- 文章 --}}
            <div class="ui segment article-content">
                {{-- 右侧工具条 --}}
                <div class="right ui rail hide-on-mobile">

                    <div class="ui sticky topic-operation">
                        <div class="ui vertical icon menu border-0">
                            <a class="item text-mute ui action topic-vote popover rm-link-color text-mute"
                               data-position="left center"
                               id="article-vote"
                               href="javascript:;"
                               data-html="点赞">
                                <i class="thumbs up icon fs-large "></i>
                                <span class="count vote-count fs-small mt-2 display-inline-block">{{ $article->vote_count }}</span>
                            </a>

                            <a class="item text-mute ui action collect popover rm-link-color text-mute"
                               data-position="left center"
                               href="javascript:;"
                               data-html="收藏">
                                <i class="heart icon fs-large "></i>
                            </a>

                            <a class="item text-mute ui action  popover rm-link-color text-mute"
                               data-position="left center"
                               href="#replies"
                               onclick="scrollToAnchor('replies')" title="评论">
                                <i class="comments icon fs-large"></i>
                                <span class="fs-small mt-2 display-inline-block">0</span>
                            </a>

                            <a class="item ui   popover rm-link-color text-mute"
                               data-position="left center" href="#topnav"
                               onclick="scrollToAnchor('topnav')" title="返回顶部">
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
                    <div class="ui readme markdown-body content-body fluidbox-content">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>

            {{-- 回复 --}}
            @include('pages.blog_articles._reply_list')
            @include('pages.blog_articles._reply_box')
            {{--@includeWhen(Auth::check(), 'pages.blog_articles._reply_box')--}}
        </div>

        @include('pages.blog_articles._sidebar')
    </div>
@endsection

@section('script')
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
    <script type="text/javascript">
        $('#article-vote').click(function () {
            var self = this;
            var icon = $(self).find('i');
            icon.addClass("spinner loading").removeClass("thumbs up");
            axios({
                url: "{{ route('api.blog.articles.upvote', $article->id) }}",
                type: 'get'
            }).then((res)=> {
                icon.addClass("thumbs up").removeClass("spinner loading");
                if (res.data.status) {
                    $(self).find('span').text(res.data.vote_count);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        type: 'error',
                        title: res.data.msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        });
    </script>
@endsection

