@extends('layouts.app')
@section('title', 'Banner')

@section('content')
    <div class="ui centered grid container main stackable blog" style="">
        <div class="twelve wide column pull-right main" style="margin-bottom: 3rem;">
            <div class="ui segment article-content">
                <div class="extra-padding">

                    @if(count($banners))
                        <div class="ui feed topic-list rm-link-color mt-0">
                            @foreach($banners as $banner)
                                <div class="event pt-3 pb-0 mb-0">
                                    <div class="content ml-3">
                                        <div class="summary " style="color: #555;">{{ $banner->title }}</div>
                                        <ul>
                                            <li><span style="color: #0d71bb;">图片 url 地址：1200 * 300 ==> </span>{{ $banner->image }}</li>
                                            <li><span style="color: #0d71bb;">图片 Alt 信息 ==> </span>{{ $banner->alt }}</li>
                                            <li><span style="color: #0d71bb;">图片盒子 背景色 ==> </span>{{ $banner->bg_color }}</li>
                                            <li><span style="color: #0d71bb;">跳转链接 url ==> </span>{{ $banner->url }}</li>
                                            <li><span style="color: #0d71bb;">是否展示前台 ==> </span>{{ $banner->show }}</li>
                                        </ul>
                                        <div style="display: flex;margin: 0 0 10px 30px;">
                                            <button type="button"><a href="{{ route('banners.edit', $banner->id) }}">编辑</a></button>
                                            <form action="{{ route('banners.destroy', $banner->id) }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit">删除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>暂无数据 ~_~ </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

@endsection
