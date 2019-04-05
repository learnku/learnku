@extends('layouts.app')
@section('title', '微信支付')

@section('content')
    <div class="ui centered grid container books-page">
        <div class="twelve wide column">
            <div class="ui piled segment">
                <div class="content extra-padding">
                    <div class="ui message olive text-center rm-link-color">
                        购买过程中出现问题，请联系 <a href="{{ route('contact.index') }}" style="text-decoration: underline;" target="_blank"><i class="icon wechat"></i> GucciLee </a>
                    </div>

                    <div class="ui tablet stackable two steps">
                        <div class="disabled step">
                            <i class="spy icon"></i>
                            <div class="content">
                                <div class="title">1. 确定订单</div>
                            </div>
                        </div>
                        <div class="active  step">
                            <i class="qrcode icon"></i>
                            <div class="content">
                                <div class="title">2. 扫码支付</div>
                            </div>
                        </div>
                    </div>

                    <div class="steps-content text-center">
                        <p style="margin: 0">
                            <b style="background: #21ba45;color: white;padding: 8px 14px;margin: 8px;border-radius: 4px;display: inline-block;letter-spacing: 0.1em;">请使用 <i class="icon wechat"></i> 微信扫码支付</b>
                        </p>

                        <p style="color: red;margin: 0;margin-top: 8px;line-height:24px">

                            请按此价格支付 <b>￥{{ $book->prices }}</b>，否则将无法自动开通！<br>

                            ⚠ 注意：支付过程中不要关闭页面，支付后会自动跳转！️

                        </p>

                        <div style="margin: 0 auto;">
                            <div id="payment-qr" style="margin-top: 20px;margin-bottom: 20px;"></div>
                            {{--<img id="payment-qr" src="{{ $order->wx_code_url }}" style="padding: 2px;border: 1px solid #eee;margin-top: 20px;margin-bottom: 20px;">--}}
                        </div>

                        <p>
                            若支付完成后没有自动跳转页面，请点击
                            <button id="paid-button" class="ui teal mini button">已完成付款</button>
                        </p>

                        <span>如已支付，却未开通，请 <a href="{{ route('contact.index') }}" target="_blank">添加微信</a>，提供支付截屏，我将手工为你开通！</span>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ assert_cdns('/ext/jquery/jquery-qrcode/jquery.qrcode.min.js') }}"></script>
    <script>
        // 生成微信支付二维码
        $('#payment-qr').qrcode({
            render: "canvas",
            width: 250,
            height: 250,
            text: "{{ $order->wx_code_url }}"
        });

        var href = "{{ route('course.orders.show', $data['order_id']) }}";
        var redirect = "{{ route('course.books.show', $book->id) }}";
        // 检查订单
        var checkOrder = function () {
            $.get( href, function( data ) {
                if (data) {
                    clearInterval(checkOrderTimmer);
                    window.onbeforeunload = function(){};
                    // 重定向
                    Swal.fire({
                        title: '支付完成，即将跳转 ...',
                        timer: 2000,
                        showCloseButton: true,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        },
                        onClose: () => {
                            if (data.status == '1') {
                                window.location.href = redirect;
                            }
                        }
                    });

                }
            });
        };

        if ('qrcode' == 'qrcode' ) {
            alert('支付过程中切忌离开页面，以免不必要的损失！');

            window.onbeforeunload = function(){
                return '支付过程中切忌离开页面，以免不必要的损失！';
            };

            var checkOrderTimmer = setInterval(function () {
                checkOrder()
            }, 3000);
        }

        // 点击 已完成付款
        $('#paid-button').click(function () {
            window.onbeforeunload = function(){};
            checkOrder()
        })
    </script>
@endsection
