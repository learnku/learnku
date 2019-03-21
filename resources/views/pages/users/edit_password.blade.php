@extends('layouts.app')

@section('title', '修改密码')

@section('content')
    <div class="ui centered grid container stackable">
        @include('pages.users._left', ['_left'=> ['active'=> 'edit_password']])

        <div class="twelve wide column">
            @include('shared._error')

            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1>
                        <i class="icon lock" aria-hidden="true"></i> 修改密码
                    </h1>

                    <div class="ui divider"></div>

                    <form class="ui form" method="POST"
                          action="{{ route('users.update_password', $user->id) }}"
                          accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label>邮 箱：</label>
                                <input name="" type="text" value="{{ $user->email }}" disabled="">
                                <input name="email" type="hidden" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="six wide field pt-3 mt-4">
                                设置密码后将可以使用此邮箱登录。
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label>密 码：</label>
                                <input type="password" class="form-control" name="password" required="">
                            </div>
                            <div class="six wide field pt-3 mt-4">

                            </div>
                        </div>

                        <div class="two fields">
                            <div class="ten wide field ">
                                <label>确认密码：</label>
                                <input type="password" class="form-control" name="password_confirmation" required="">
                            </div>
                            <div class="six wide field pt-3 mt-4">

                            </div>
                        </div>

                        <div class="field mt-4">
                            <div class="col-sm-offset-2 col-sm-6">
                                <input class="ui button primary" id="user-edit-submit" type="submit" value="应用修改">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
