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

    <title>@yield('title', 'LearnKu') - LearnKu 编码学习区</title>
    <meta name="Description" content="@yield('Description',  '终身学习者的编程学习区')">
    <meta name="Keywords" content="@yield('Keywords', '学习区,学习去,编码知识区,博客,开发者博客')">
    <meta name="author" content="GucciLee" />

      <!-- Styles -->
    <link href="{{ assert_cdns('css/learnku.css') }}" rel="stylesheet">
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
    {{-- 网页主体 --}}
    @yield('body')

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

    {{-- 加入群聊 --}}
    <a class="circular ui icon button fixed feedback popover"
       target="_blank"
       data-content="点击加入 Q 群： 304574522"
       data-variation="inverted"
       data-position="left center"
       href="//shang.qq.com/wpa/qunwpa?idkey=d0ae1ecab906fda90348e051314ac221d0386ead9607b698d7e5b60269b56080">
        <i class="icon talk outline"></i>
    </a>

    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif

    <!-- Scripts -->
    <script type="text/javascript" src="{{ assert_cdns('js/learnku.js') }}"></script>
    @yield('script')

    {{-- 统计代码 --}}
    @if(!app()->isLocal())
    {{-- 百度统计 --}}
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?1ec6a674ead84d248649ad718fcb2c4d";
            hm.async = true;
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

    {{-- 友盟 --}}
    <div style="display: none;">
        <script async type="text/javascript" src="https://s23.cnzz.com/z_stat.php?id=1276509064&web_id=1276509064"></script>
    </div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137692440-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-137692440-1');
    </script>
    @endif
</body>
</html>
