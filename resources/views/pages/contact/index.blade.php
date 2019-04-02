@extends('layouts.app')
@section('title', '联系我')

@section('content')
    <div class="ui centered grid container mt-5 pt-3">
        <div class="six wide column">
            <div class="ui stacked segment">
                <div class="content">

                    <div class="text-center">

                        <div class="ui message warning">
                            <i class="icon info"></i>
                            添加微信请道明来意，谢谢 <img title=":wink:" alt=":wink:" class="emoji" src="{{ asset('/images/public/wink.png') }}" align="absmiddle">
                        </div>

                        <img src="{{ asset('/images/public/wechat.jpg') }}" alt="" width="250" style="border: 2px solid #e4e4e4;border-radius: 4px;margin-bottom: 18px;">
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
