<nav class="ui main borderless menu top stackable" id="topnav">
  <div class="ui container">
    <a href="/" class="item secondary">
      网站首页
    </a>
    <a href="" class="item secondary">
      文章专栏
    </a>
    <a href="" class="item secondary">
      关于本站
    </a>

    {{-- 搜索 --}}
    <form class="ui fluid category search item secondary" action="/" method="GET">
      <div class="ui icon input">
        <input class="prompt" name="q" type="text" placeholder="搜索" autocomplete="off">
        <i class="search icon"></i>
      </div>
      <div class="results"></div>
    </form>

    {{-- 右侧导航 --}}
    <div class=" right menu stackable secondary">
      @guest
        <div class="item rm-link-color">
          <a class="mr-4 no-pjax login_required" href="{{ route('login') }}"><i class="icon sign in "></i> 登录 </a>
          <a class="no-pjax" href="{{ route('register') }}" style="margin-left: 10px;"><i class="icon user add "></i> 注册 </a>
        </div>
      @else
        {{-- 添加博文 --}}
        <div class="ui simple item dropdown article stackable nav-user-item  secondary" tabindex="0">
          <i class="icon paint brush"></i>  <i class="dropdown icon"></i>

          <div class="ui menu stackable" tabindex="-1">
            <a href="" class="item no-pjax">
              <i class="icon paint brush"></i> 新建博文
            </a>
          </div>
        </div>

        {{-- 个人中心 --}}
        <div class="ui simple item dropdown article stackable nav-user-item" tabindex="0">
          <img class="ui avatar image" src="{{ assert_images(isset(Auth::user()->info->image->path) ? Auth::user()->info->image->path : '') }}"> &nbsp;{{ Auth::user()->name }}
          <i class="dropdown icon"></i>
          <div class="ui menu stackable" tabindex="-1">
            <a href="/" class="item">
              <i class="icon heart"></i> 我的收藏
            </a>

            <a href="{{ route('users.show', Auth::id()) }}" class="item">
              <i class="icon user"></i>
              个人中心
            </a>

            <a href="{{ route('users.edit', Auth::id()) }}" class="item">
              <i class="icon settings"></i>
              编辑资料
            </a>

            <a class="item no-pjax" href="javascript:void(0)"
               data-url="{{ route('logout') }}"
               data-method="POST"
               data-prompt="您确定要退出登录吗？"
               title="退出登录" style="cursor: pointer;">
              <i class="icon sign out"></i>
              退出
            </a>
          </div>
        </div>
      @endguest
    </div>
  </div>
</nav>
