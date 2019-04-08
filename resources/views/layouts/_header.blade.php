<nav class="ui main borderless menu top stackable" id="topnav">
    <div class="ui container">
        <a href="/" class="item secondary">
            网站首页
        </a>
        <a href="{{ route('blog.articles.index') }}" class="item secondary">
            博客
        </a>
        <div class="ui simple item dropdown article stackable nav-user-item  secondary">
            教程  <i class="dropdown icon"></i>

            <div class="ui menu stackable">
                <a href="{{ route('course.books.index') }}" class="item">
                    <i class="icon home"></i> 实战教程首页
                </a>
                @foreach(\App\Models\CourseBook::all() as $book)
                    @if(!empty(Auth()->user()) && Auth()->user()->hasRole('Founder'))
                        <a class="item" href="{{ route('course.books.show', $book->id) }}"
                           style="padding-right: 36px!important;">
                            <img class="ui avatar image" src="{{ assert_images($book->image['path']) }}" style="width:20px;height:20px;margin-top: 0;margin-bottom: 0;">
                            {{ $book->title }}
                        </a>
                    @elseif((int)$book->prices <= 1000)
                        <a class="item" href="{{ route('course.books.show', $book->id) }}"
                           style="padding-right: 36px!important;">
                            <img class="ui avatar image" src="{{ assert_images($book->image['path']) }}" style="width:20px;height:20px;margin-top: 0;margin-bottom: 0;">
                            {{ $book->title }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        <a href="{{ route('contact.index') }}" class="item secondary">
            关于本站
        </a>

        {{-- 搜索 vue --}}
        <form id="header-search-app" class="ui fluid category search item secondary"
              data-api="{{ route('api.search.index') }}"
              action="{{ route('search.index') }}" method="GET">
            <div class="ui icon input" :class="{ 'loading' : loading }">
                <select class="ui compact selection dropdown header-search-left"
                        v-model="form.search_type"
                        id="header-search-left">
                    <option value="is_all">所有</option>
                    <option selected="selected" value="is_blog">文章</option>
                </select>
                <input class="prompt header-search-right"
                       type="text"
                       placeholder="搜索"
                       autocomplete="off"
                       @input.stop="search($event)" @focus.stop="search($event)"
                       name="q"
                       data-value="{{ old('q', isset($data['search']['q'])) ? $data['search']['q'] : '' }}"
                       v-model="form.q">
                <i class="search icon"></i>
            </div>
            <div class="results transition"
                 :class="{ visible:  search_blog_results.length && search_has_results }"
                 id="search-results">
                <a class="result" v-for="item in search_blog_results" :href="item.href">
                    <div class="content">
                        <div class="title" v-text="item.title"></div>
                        <div class="description" v-text="item.excerpt"></div>
                    </div>
                </a>
                <a :href="search_all_url" class="action"><i class="icon search"></i>搜全站</a>
            </div>
            <div class="results transition"
                :class="{ visible: search_no_results }">
                <div class="message empty">
                    <div class="header">结果为空</div>
                    <div class="description">搜索结果为空！</div>
                    <a :href="search_all_url" class="action ui button mt-3 fluid">
                        <i class="icon search"></i>
                        搜全站
                    </a>
                </div>
            </div>
        </form>

        {{-- 右侧导航 --}}
        <div class=" right menu stackable secondary">
            @guest
                <div class="item rm-link-color">
                    <a class="mr-4 no-pjax login_required" href="{{ route('login') }}"><i class="icon sign in "></i> 登录
                    </a>
                    <a class="no-pjax" href="{{ route('register') }}" style="margin-left: 10px;"><i
                            class="icon user add "></i> 注册 </a>
                </div>
            @else
                {{-- 添加博文 --}}
                @if(Auth()->user()->hasRole('Founder'))
                    <div class="ui simple item dropdown article stackable nav-user-item  secondary" tabindex="0">
                        <i class="icon paint brush"></i> <i class="dropdown icon"></i>
                        <div class="ui menu stackable" tabindex="-1">
                            <a href="{{ route('blog.articles.create') }}" class="item no-pjax">
                                <i class="icon paint brush"></i> 新建博文
                            </a>
                            <a href="{{ route('course.books.create') }}" class="item no-pjax">
                                <i class="icon paint brush"></i> 新建教程
                            </a>
                        </div>
                    </div>
                @endif

                {{-- 消息通知 --}}
                <a class="item" href="{{ route('notifications.index') }}" title="消息通知">
                <span
                    class="{{ Auth::user()->notification_count > 0 ? 'red' : 'basic' }} ui circular label notification"
                    id="notification-count">
                    {{ Auth::user()->notification_count }}
                </span>
                </a>

                {{-- 个人中心 --}}
                <div class="ui simple item dropdown article stackable nav-user-item" tabindex="0">
                    <img class="ui avatar image lazy"
                         data-original="{{ assert_images(isset( $common['auth']['avatar_path'] ) ? $common['auth']['avatar_path'] : '') }}">
                    &nbsp;
                    {{ $common['auth']['name'] }}
                    <i class="dropdown icon"></i>
                    <div class="ui menu stackable" tabindex="-1">
                        {{-- 是否是站长 --}}
                        @if(Auth()->user()->hasRole('Founder'))
                            <a href="/horizon" class="item" target="_blank">
                                <i class="icon heart"></i> Laravel Horizon
                            </a>
                            <a class="item" href="{{ route('qinius.index') }}">
                                <i class="icon heart"></i> 七牛管理
                            </a>
                        @endif
                        <a href="{{ route('course.orders.index') }}" class="item">
                            <i class="icon heart"></i> 我的订单
                        </a>
                        {{--<a href="/" class="item">
                            <i class="icon heart"></i> 我的收藏
                        </a>--}}

                        <a href="{{ route('users.show', $common['auth']['id']) }}" class="item">
                            <i class="icon user"></i>
                            个人中心
                        </a>

                        <a href="{{ route('users.edit', $common['auth']['id']) }}" class="item">
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
