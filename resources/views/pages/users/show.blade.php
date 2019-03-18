@extends('layouts.app')
@section('title', $user->name . '的个人信息')

@section('content')
    <div class="ui centered grid container stackable">
        @include('pages.users._left', ['_left'=> ['active'=> 'show']])

        <div class="twelve wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1>
                        <i class="icon user" aria-hidden="true"></i> {{ $user->name }} 个人信息
                    </h1>
                    <div class="ui divider"></div>

                    <div>
                        <div class="ui segment text-center">注册于：<span class="ui popover" title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</span> ，最后活跃于：<span class="ui popover" title="{{ now() }}">{{ now()->diffForHumans() }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
