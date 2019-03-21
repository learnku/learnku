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
                        <input type="hidden" name="image_id" value="{{ old('image_id', $user->info->image_id) }}">

                        <div>
                            <img id="upload-img"
                                 class="upload-img image-border ui popover"
                                 data-variation="inverted"
                                 data-content="【点击我】上传图片吧"
                                 src="{{ default_img(isset($user->info->image->path) ? $user->info->image->path : '') }}" width="320">
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
    $("#upload-img").click(function () {
        let self = this;
        new MyUploadOne({
            'file_type': 'avatar',
            success: function (res) {
                let path = assert_images(res.data.path);
                $(self).attr('src', path);
                $(self).closest('form').find("input[name='image_id']").val(res.data.id);
            }
        });
    });
</script>
@endsection
