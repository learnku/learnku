<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LearnKu') - LearnKu 编码知识博客</title>
  <meta name="Description" content="@yield('Description',  'LearnKu 编码知识博客')">
  <meta name="Keywords" content="@yield('Keywords', 'LearnKu,博客,开发者博客,编码知识博客')">

  <!-- Styles -->
  <link href="{{ mix('css/learnku.css') }}" rel="stylesheet">
  @yield('style')

  <script type="text/javascript">
    window.Config = {
      'token': "{{ csrf_token() }}",
      'url': "{{ config('app.url') }}",
      'following_users': ['GucciLee'],
      'routes': {
        'api_search': '',
        'upload_image': '{{ config('app.url') }}' + '/uploads',
        'cdn_store': ''
      }
    };
  </script>
</head>
<body class="pushable {{ route_class() }}-page">
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
