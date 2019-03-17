@extends('layouts.app')

@section('content')
  <div class="ui middle aligned center aligned grid column-max-width-500">
    <div class="column">
      <h2 class="ui teal image header">
        <div class="content">
          登录到您的帐户
        </div>
      </h2>
      <form class="ui large form error" method="post" action="{{ route('login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="ui stacked segment">
          <div class="field">
            @if ($errors->has('email'))
              <div class="ui error message">
                <p>{{ $errors->first('email') }}</p>
              </div>
            @endif
            @if ($errors->has('password'))
              <div class="ui error message">
                <p>{{ $errors->first('password') }}</p>
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input type="email"
                     name="email" placeholder="E-mail address"
                     value="{{ old('email') }}" required autofocus>
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input type="password" name="password"
                     placeholder="Password" required>
            </div>
          </div>
          <div class="field" style="display: flex;">
            <div class="ui checkbox">
              <input type="checkbox" tabindex="0" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">{{ __('Remember Me') }}</label>
            </div>
          </div>
          <button class="ui fluid large teal submit button">{{ __('Login') }}</button>
          <div class="field" style="display: flex;padding-top: 10px;justify-content: center;">
            @if (Route::has('password.request'))
              <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
              </a>
            @endif
          </div>
        </div>

        <div class="ui error message"></div>

      </form>

      <div class="ui message">
        创建一个用户? <a href="{{ route('register') }}">注册</a>
      </div>
    </div>
  </div>
@endsection
