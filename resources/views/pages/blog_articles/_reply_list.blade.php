{{-- 回复列表 --}}
<div id="replies" name="replies"></div>
<div class="ui threaded comments comment-list ">
    <div class="ui divider horizontal grey">
        <i class="icon comments"></i> 讨论数量: <span class="reply-count">{{ count($replies) }}</span>
    </div>

    <div class="comments-feed">
        @foreach($replies as $index=> $reply)
        <div class="comment">
            <div class="avatar">
                <a href="{{ route('users.show', $reply->user_id) }}">
                    <img class="lazy" data-original="{{ $reply->avatar_path }}">
                </a>
            </div>
            <div class="content">
                <div class="comment-header">
                    <div class="meta">
                        <a class="author" href="{{ route('users.show', $reply->user_id) }}">
                            {{ $reply->user->name }}
                        </a>
                    </div>
                </div>

                <div class="text comment-body markdown-reply fluidbox-content">
                    <div class="px-3">
                        <p>{!! $reply->content !!}</p>
                    </div>
                </div>

                <div class="" title="2019-01-19 11:48:18" style="background: #fff;padding: 15px;font-size: 12px;padding-top:0;color: rgba(0, 0, 0, 0.4);">
                    <i class="icon clock"></i> {{ $reply->created_at->diffForHumans() }}
                </div>

                <div class="footer">
                    <div class="ui menu reactions">
                        {{-- 点赞 --}}
                        <a class="item reply-upvote ui popover" href="javascript:;"
                           title="为此评论点赞"
                           data-id="{{ $reply->id }}"
                           style="color:rgba(0, 0, 0, 0.4);font-size: 0.9em;">
                            <i class="reaction-emoji  icon thumbs up outline"></i>
                            <span class="vote-count"></span>
                        </a>
                        {{-- 举报 --}}
                        {{--<a class="item ui popover  report-modal"
                           data-content="举报违规内容，共建品质社区"
                           href="{{ route('contact.index') }}">
                            <i class="icon flag outline"></i> 举报
                        </a>--}}

                        {{-- 编辑 --}}
                        {{--<a class="item ui " style="color:rgba(0, 0, 0, 0.4);font-size: 0.9em;" href="">
                            <i class="icon edit" style="margin: 0;width: 1em;"></i>
                        </a>--}}

                        {{-- 删除 --}}
                        @can('destroy', $reply)
                        <a class="item ui " style="cursor: pointer;"
                           href="javascript:;"
                           data-method="delete"
                           data-url="{{ route('blog.replies.destroy', $reply->id) }}">
                            <i class="icon trash" style="margin: 0;width: 1em;color:rgba(0, 0, 0, 0.4);font-size: 0.9em;"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
