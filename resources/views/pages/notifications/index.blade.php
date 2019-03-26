@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="ui centered grid container stackable">
        <div class="wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1><i class="bell outline icon"></i> 我的通知</h1>
                    <div class="ui divider mb-0"></div>
                    <div class="ui feed notifications mt-0 rm-link-color text-decoration-underline">
                        {{-- 列表 --}}
                        @if($notifications->count())
                            @foreach ($notifications as $notification)
                                <div class="event  pt-4 pb-3 px-0 mb-0 " style="border-radius: 4px;">
                                    <div class="content">
                                        <div class="summary">
                                            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
                                            • 回复了你:
                                            <a href="{{ $notification->data['article_link'] }}">{{ $notification->data['article_title'] }}</a>

                                            <span class="date pull-right">
                                        <i class="icon time"></i>
                                        <span title="{{ $notification->created_at }}">{{ $notification->created_at->diffForHumans() }}</span>
                                    </span>
                                        </div>

                                        <div class=" markdown-reply mt-2">
                                            {!! markdownToHtml($notification->data['reply_content']) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>没有消息通知 !</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
