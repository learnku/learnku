<div class="ui modal login small" style="width:400px;">
    <i class="close icon"></i>
    <div class="header">
        <h4 class="modal-title ">
            <span style="position: relative;top: 4px;">请登录</span>
        </h4>
    </div>
    <div class="content">
        <form class="ui form login" role="form" method="POST"
              onsubmit="return false"
              action="{{ route('api.authorizations.store') }}"
              accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="remember" value="yes">
            <input type="hidden" name="return_back" value="no">

            <div class="field">
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="email" placeholder="邮 箱" value="" required="">
                </div>
            </div>
            <div class="field">
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" name="password" placeholder="密 码" value="" required="">
                </div>
            </div>
            <button class="ui green right labeled icon button" type="submit">
                <i class="right arrow icon"></i>
                提交
            </button>

            <div class="pull-right mt-2 rm-link-color">
                <a class="btn btn-link " href="{{ route('password.request') }}" target="_blank">
                    忘记密码?
                </a>
                <span class="text-mute">or</span>
                <a class="btn btn-link " href="{{ route('register') }}" target="_blank">
                    注册
                </a>
            </div>

            <div class="clearfix"></div>


            {{--<div class="ui horizontal divider fs-tiny text-mute">
                第三方账号登录
            </div>--}}
        </form>
    </div>
</div>
