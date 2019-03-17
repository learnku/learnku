@extends('layouts.app')

@section('content')
  <div class="ui middle aligned center aligned grid column-max-width-500">
    <div class="column">
      <h2 class="ui teal image header">
        <div class="content">
          {{ __('Reset Password') }}
        </div>
      </h2>
      <form class="ui large form error" method="post" action="{{ route('password.update') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="ui stacked segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="envelope icon"></i>
              <input id="email" type="email"
                     placeholder="{{ __('E-Mail Address') }}"
                     name="email" value="{{ $email ?? old('email') }}" required autofocus>
            </div>
            @if ($errors->has('email'))
              <div class="ui error message">
                {{ $errors->first('email') }}
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input id="password" type="password" name="password"
                     placeholder="{{ __('Password') }}" required>
            </div>
            @if ($errors->has('password'))
              <div class="ui error message">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input id="password-confirm" type="password"
                     placeholder="{{ __('Confirm Password') }}"
                     class="form-control" name="password_confirmation" required>
            </div>
          </div>

          <button class="ui fluid large teal submit button">{{ __('Reset Password') }}</button>
        </div>
      </form>
    </div>
  </div>
@endsection
