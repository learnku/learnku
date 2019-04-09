@extends('layouts.app')
@section('title', 'Banner')

@section('content')
    @include('shared._error')

    <div class="ui centered grid container stackable">
        <div class="twelve wide column">
            <div class="ui segment">
                <a class="ui right corner label compose-help" href="javascript:;">
                    <i class="info icon"></i>
                </a>

                <div class="content extra-padding">

                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        @if($banner->id)
                            <i class="icon paint brush"></i>编辑 Banner
                        @else
                            <i class="icon paint brush"></i>新建 Banner
                        @endif
                    </div>

                    @if($banner->id)
                    <form id="article-update-form"
                              class="ui form"
                              style="min-height: 50px;"
                              action="{{ route('banners.update', $banner->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                    <form id="article-create-form"
                                      style="min-height: 50px;"
                                      class="ui form"
                                      action="{{ route('banners.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="field">
                            <label>图片 url 地址：1200 * 300</label>
                            <input class="form-control" type="text" name="image"
                                   id="title-field" value="{{ old('image', $banner->image ) }}"
                                   placeholder="请填写 Banner 图片 url 地址" required="">
                        </div>
                        <div class="field">
                            <label>图片 Alt 信息</label>
                            <input class="form-control" type="text" name="alt"
                                   id="title-field" value="{{ old('alt', $banner->alt ) }}"
                                   placeholder="请填写 Banner 图片 Alt 信息" required="">
                        </div>
                        <div class="field">
                            <label>图片盒子 背景色</label>
                            <input class="form-control" type="text" name="bg_color"
                                   id="title-field" value="{{ old('bg_color', $banner->bg_color ) }}"
                                   placeholder="请填写 图片盒子 背景色" required="">
                        </div>
                        <div class="field">
                            <label>跳转链接 url</label>
                            <input class="form-control" type="text" name="url"
                                   id="title-field" value="{{ old('url', $banner->url ) }}"
                                   placeholder="请填写 跳转链接 url" required="">
                        </div>
                        <div class="field">
                            <label>标题 title</label>
                            <input class="form-control" type="text" name="title"
                                   id="title-field" value="{{ old('title', $banner->title ) }}"
                                   placeholder="标题 title">
                        </div>
                        <div class="field">
                            <label>是否展示前台</label>
                            <div class="field">
                                <div class="ui fluid selection dropdown">
                                    {{-- 设置此值会自动设置默认值 --}}
                                    <input type="hidden" name="show" value="{{ old('show', $banner->show) }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">是否展示前台</div>
                                    <div class="menu">
                                        <div class="item" data-value="1">显示</div>
                                        <div class="item" data-value="0">不显示</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div contenteditable="true" id="pastebin"></div>

                        <div class="ui message">
                            <button type="submit" class="ui button primary publish-btn loading-on-clicked" id="">
                                <i class="icon send"></i>
                                发布 Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
