@extends('layouts.app')

@section('content')
  {{-- 错误消息 --}}
  @include('shared._error')

  <div class="ui middle aligned center aligned grid column-max-width-500">
    <div class="column">
      <h2 class="ui teal image header">
        <div class="content">
          {{ __('Reset Password') }}
        </div>
      </h2>
      <form class="ui large form error" method="post" action="{{ route('password.email') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="ui stacked segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="envelope icon"></i>
              <input id="email" type="email"
                     placeholder="{{ __('E-Mail Address') }}"
                     name="email" value="{{ old('email') }}" required>
            </div>
          </div>
          <button class="ui fluid large teal submit button">{{ __('Send Password Reset Link') }}</button>
        </div>
      </form>
    </div>
  </div>
@endsection
