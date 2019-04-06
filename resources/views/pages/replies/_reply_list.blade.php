{{-- 回复列表 --}}
<div id="replies" name="replies"></div>
<div class="ui threaded comments comment-list">
    <div class="ui divider horizontal grey">
        <i class="icon comments"></i> 讨论数量: <span class="reply-count">{{ count($replies) }}</span>
    </div>

    <div class="comments-feed">
        @foreach($replies as $index=> $reply)
        <div class="comment">
            <div class="avatar">
                <a href="{{ route('users.show', $reply->user_id) }}">
                    <img class="lazy" data-original="{{ assert_images($reply->avatar_path) }}">
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
                        <p>{!! markdownToHtml($reply->content) !!}</p>
                    </div>
                </div>

                <div class="" title="2019-01-19 11:48:18" style="background: #fff;padding: 15px;font-size: 12px;padding-top:0;color: rgba(0, 0, 0, 0.4);">
                    <i class="icon clock"></i> {{ $reply->created_at->diffForHumans() }}
                </div>

                @if($reply->user_id === \Illuminate\Support\Facades\Auth::id())
                <div class="footer">
                    <div class="ui menu reactions">
                        {{-- 编辑 --}}
                        <a class="item ui " style="color:rgba(0, 0, 0, 0.4);font-size: 0.9em;" href="{{ route('replies.edit', $reply->id) }}">
                            <i class="icon edit" style="margin: 0;width: 1em;"></i>
                        </a>

                        {{-- 删除 --}}
                        <a class="item ui " style="cursor: pointer;"
                           href="javascript:;"
                           axios-method="delete"
                           data-url="{{ route('api.replies.destroy', $reply->id) }}">
                            <i class="icon trash" style="margin: 0;width: 1em;color:rgba(0, 0, 0, 0.4);font-size: 0.9em;"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
