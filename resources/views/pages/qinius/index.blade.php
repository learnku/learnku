@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="ui centered grid container stackable" style="width: 1300px !important;">
        <div class="wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1><i class="bell outline icon"></i> 七牛管理
                    </h1>
                    <div class="ui divider mb-0"></div>

                    <div class="ui list">
                        <div class="item">
                            <i class="file icon"></i>
                            <div class="content">
                                <div class="header">
                                    <a href="{{ route('qinius.images') }}">图片库管理</a>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <i class="folder icon"></i>
                            <div class="content">
                                <div class="header">CDN 静态资源管理</div>
                                <div class="list">
                                    <div class="item">
                                        <i class="folder icon"></i>
                                        <div class="content">
                                            <div class="header">
                                                <a href="{{ route('qinius.cdns') }}?action=delete">清空静态资源</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <i class="folder icon"></i>
                                        <div class="content">
                                            <div class="header">
                                                <a href="{{ route('qinius.cdns') }}?action=create">上传静态资源</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <i class="folder icon"></i>
                                        <div class="content">
                                            <div class="header">
                                                <a href="{{ route('qinius.cdns') }}?action=refresh">刷新预取</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui divider mb-20"></div>

                        <div class="item">
                            <i class="folder icon"></i>
                            <div class="content">
                                <div class="header">提交链接到搜索引擎</div>
                                <div class="list">

                                    <div class="item">
                                        <i class="folder icon"></i>
                                        <div class="content">
                                            <div class="header">
                                                <a href="{{ route('qinius.urls') }}?action=baidu">提交到百度（www.learnku.net）</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
