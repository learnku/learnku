@extends('layouts.app')

@section('content')
  <div class="ui middle aligned center aligned grid column-max-width-500">
    <div class="column">
      <h2 class="ui teal image header">
        <div class="content">
          创建您的账户
        </div>
      </h2>
      <form class="ui large form error" method="post" action="{{ route('register') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="ui stacked segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input id="name" type="text"
                     placeholder="{{ __('Name') }}"
                     name="name" value="{{ old('name') }}" required autofocus>
            </div>
            @if ($errors->has('name'))
              <div class="ui error message">
                <p>{{ $errors->first('name') }}</p>
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="envelope icon"></i>
              <input id="email" type="email"
                     placeholder="{{ __('E-Mail Address') }}"
                     name="email" value="{{ old('email') }}" required>
            </div>
            @if ($errors->has('email'))
              <div class="ui error message">
                <p>{{ $errors->first('email') }}</p>
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input id="password" type="password"
                     placeholder="{{ __('Password') }}"
                     name="password" required>
            </div>
            @if ($errors->has('password'))
              <div class="ui error message">
                <p>{{ $errors->first('password') }}</p>
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input id="password-confirm" type="password" class="form-control"
                     placeholder="{{ __('Confirm Password') }}"
                     name="password_confirmation" required>
            </div>
          </div>
          {{--<div class="field" style="display: flex;flex-wrap: wrap;">
            <div class="ui left icon input">
              <i class="user secret icon"></i>
              <input id="captcha" placeholder="验证码" name="captcha" required>
            </div>
            <img class="thumbnail captcha mt-3 mb-2 ui popover"
                 style="position: relative;"
                 data-position="right center"
                 title="点击图片重新获取图片验证码"
                 src="{{ captcha_src('flat') }}"
                 onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">--}}
            @if ($errors->has('captcha'))
              <div class="ui error message">
                <p>{{ $errors->first('captcha') }}</p>
              </div>
            @endif
          </div>

          <button class="ui fluid large teal submit button">{{ __('Register') }}</button>
        </div>
      </form>
    </div>
  </div>
@endsection
