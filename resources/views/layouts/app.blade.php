<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    {{-- JWT Token --}}
    <meta name="jwt-token" content="{{ 'Bearer '.JWTAuth::fromUser(Auth::user()) }}">
    @endauth

    <title>@yield('title', 'LearnKu') - LearnKu 编码知识博客</title>
    <meta name="Description" content="@yield('Description',  'LearnKu 编码知识博客')">
    <meta name="Keywords" content="@yield('Keywords', 'LearnKu,博客,开发者博客,编码知识博客')">

      <!-- Styles -->
    <link href="{{ mix('css/learnku.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ assert_cdns('/ext/prism/prism.css') }}">
    @yield('style')

    <script type="text/javascript">
        window.Config = {
            'token': "{{ csrf_token() }}",
            'isApi': false,
            'url': "{{ config('app.url') }}",
            'routes': {
                'images_domain': "{{ config('app.images_url') }}",
                'cdns_domain': "{{ config('app.cdns_url') }}",
                'upload_image': "{{ route('api.images.store') }}",
                'api_search': "{{ route('api.search.index') }}",
                'search': "{{ route('search.index') }}",
            }
        };
    </script>
</head>
<body class="pushable {{ route_class() }}-page">
    {{-- 登录弹窗 --}}
    @include('layouts._login')

    <div class="pusher">
        <div class="main container" style="min-height: 80vh;">
            {{-- 网页头 --}}
            @include('layouts._header')

            {{-- 消息提示信息 --}}
            @include('shared._messages')

            {{-- 网页主体 --}}
            @yield('content')
        </div>

        {{-- 网页底部 --}}
        @include('layouts._footer')
    </div>

    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif

    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('js/learnku.js') }}"></script>
    @yield('script')

    {{-- 推送代码 --}}
    @if(!app()->isLocal())
    {{-- 百度推送 --}}
    <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
    @endif

    {{-- 统计代码 --}}
    @if(!app()->isLocal())
    {{-- 百度统计 --}}
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?1ec6a674ead84d248649ad718fcb2c4d";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

    {{-- 友盟 --}}
    <div style="display: none;">
        <script type="text/javascript" src="https://s23.cnzz.com/z_stat.php?id=1276509064&web_id=1276509064"></script>
    </div>
    @endif
</body>
</html>
