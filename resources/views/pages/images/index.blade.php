@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="ui centered grid container stackable">
        <div class="wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1><i class="bell outline icon"></i> 七牛图片库</h1>
                    <div class="ui divider mb-0"></div>

                    {{-- 图片列表 --}}
                    <div class="ui small images" style="margin-top: 20px;">
                        @foreach($images as $img)
                            <img class="lazy" data-original="{{ assert_images($img['key'], true) }}">
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
