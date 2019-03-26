@extends('layouts.app')

@section('content')
    @include('shared._error')

    <div class="ui centered grid container stackable">
        <div class="twelve wide column">
            <div class="ui segment">

                <div class="content extra-padding">

                    <div class="ui message">
                        正在编辑 <a href="{{ route('blog.articles.show', $reply->article_id) }}">{{  $reply->article->title }}</a> 下的评论
                    </div>

                    <div class="ui message warning">
                        请保持友善，分享美好的事物。
                    </div>

                    <form method="POST" action="{{ route('blog.replies.update', $reply->id) }}"
                          accept-charset="UTF-8" id="topic-edit-form" class="topic-form">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            {{-- 加载 markdown 编辑器 --}}
                            <div class="markdown-base">
                                <textarea
                                    id="markdown-editor"
                                    name="content"
                                    placeholder="请输入至少三个字符的内容。"
                                    rows="6">{{ old('content', $reply->content) }}</textarea>
                            </div>
                        </div>

                        <div contenteditable="true" id="pastebin"></div>

                        <div class="form-group status-post-submit">
                            <button class="button ui primary submit-btn" id="topic-submit" type="submit">发 布</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="four wide column">

            <div class="ui stacked segment">
                <div class="content">
                    <h2>社区规则</h2>

                    <div class="ui divider"></div>


                    <ul class="ui bulleted list ">
                        <li class="item lh-3">请传播美好的事物，这里拒绝低俗、诋毁、谩骂等相关信息</li>
                        <li class="item lh-3">请尽量分享技术相关的话题，谢绝发布社会, 政治等相关新闻</li>
                        <li class="item lh-3">这里绝对不讨论任何有关盗版软件、音乐、电影如何获得的问题</li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    @include('common.markdown_edit')
    <script type="text/javascript">
        var markdown = new Markdown();
        markdown.init({
            'textarea': {
                'id': 'markdown-editor',
            }
        });
    </script>
@endsection
