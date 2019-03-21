@extends('layouts.app')

@section('title', '修改头像')

@section('content')
    <style type="text/css">
        .web-upload-base{
            position: relative;
            background-color: #fafafa;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, .05);
            border: 1px solid rgba(34, 36, 38, 0.15);
        }
    </style>
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
                        <input type="hidden" name="avatar_image_id" value="">

                        <div id="image-preview-div">
                            <img id="preview-img" class="avatar-preview-img image-border " src="" width="320">
                        </div>

                        <div class="mb-3 mt-3">
                            <button class="ui button" id="test" type="button">上传图片</button>
                        </div>

                        <div class="filed mt-3">
                            <button class="ui button primary" id="upload-button" type="submit">更新头像资料</button>
                        </div>
                    </form>
            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $("#test").click(function () {
        new MyUploadOne();
    });
</script>
@endsection
