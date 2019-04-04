@extends('layouts.app')
@section('title', '确认订单')

@section('content')
    <div class="ui centered grid container books-page">
        <div class="twelve wide column">
            <div class="ui piled segment">
                <div class="content extra-padding">
                    <div class="ui message olive text-center rm-link-color">
                        购买过程中出现问题，请联系 <a href="{{ route('contact.index') }}" style="text-decoration: underline;" target="_blank"><i class="icon wechat"></i> GucciLee </a>
                    </div>

                    <div class="ui tablet stackable two steps">
                        <div class="active step">
                            <i class="spy icon"></i>
                            <div class="content">
                                <div class="title">1. 确定订单</div>
                            </div>
                        </div>
                        <div class="disabled  step">
                            <i class="qrcode icon"></i>
                            <div class="content">
                                <div class="title">2. 扫码支付</div>
                            </div>
                        </div>
                    </div>

                    <div class="steps-content text-center">
                        <table class="ui definition table" style="width: 500px;margin: 0 auto 30px">
                            <tbody>
                            <tr>
                                <td class="three wide column">教程名称</td>
                                <td><a href="{{ route('course.books.show', $book->id) }}" target="_blank">{{ $book->title }}</a></td>
                            </tr>
                            <tr>
                                <td>教程单价</td>
                                <td><span style="font-size: 20px;font-weight: bold;color: #F2711C">￥{{ $book->prices }}</span></td>
                            </tr>
                            <tr>
                                <td>支付方式</td>
                                <td>微信{{-- / 支付宝--}}</td>
                            </tr>
                            </tbody>
                        </table>

                        <p>请选择支付方式：</p>
                        <a class="ui button green no-pjax" href="{{ route('course.purchases.index', $book->id) }}?step=qrcode&type=1"> <i class="icon wechat"></i> 微信支付</a>
                        {{--<a class="ui button teal no-pjax" href="{{ route('course.purchases.index', $book->id) }}?step=qrcode&type=2" style="background-color: #03b1f5;">
                            支付宝支付
                        </a>--}}
                        <br>
                        <br>
                        <p class="ui text mute">请注意，虚拟内容商品，购买后不支持退货、转让、退换，请斟酌确认。</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
