@extends('layouts.app')

@section('title', '修改头像')

@section('content')
    <div class="ui centered grid container stackable">
        @include('pages.users._left', ['_left'=> ['active'=> 'edit_avatar']])

        <div class="twelve wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1>
                        <i class="icon image" aria-hidden="true"></i> 修改头像
                    </h1>

                    <div class="ui divider"></div>

                    <form class="ui form"
                          method="POST"
                          action="{{ route('users.update_avatar', $user->id) }}"
                          enctype="multipart/form-data"
                          accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @if($user->info->avatar)
                        <div id="image-preview-div">
                            <img id="preview-img" class="avatar-preview-img image-border " src="{{ $user->info->avatar }}" width="320">
                        </div>
                        @endif

                        <div class="mb-3 mt-3">
                            <label for="exampleInputFile">请选择图片：</label>
                        </div>


                        <div class="filed">
                            <input type="file" name="avatar" id="file" required="">
                        </div>

                        <div class="filed mt-3">
                            <button class="ui button primary" id="upload-button" type="submit">上传头像</button>
                        </div>


                        <div class="ui message warning" id="loading" style="display: none;" role="alert">
                            图片上传中...
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <div id="message"></div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
