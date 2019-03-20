@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="ui cards">
        <div class="card">
            <div class="web-uploads">
                <div class="queueList">
                    <div class="placeholder">
                        <div id="filePicker"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        // 实例化
        uploader = WebUploader.create({
            pick: {
                id: '#filePicker',
                label: '点击选择图片'
            },
            paste: document.body,
            fileVal: 'file',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },

            disableGlobalDnd: true,

            chunked: true,
            // server: 'http://webuploader.duapp.com/server/fileupload.php',
            server: 'http://2betop.net/fileupload.php',
            fileNumLimit: 300,
            fileSizeLimit: 5 * 1024 * 1024,    // 200 M
            fileSingleSizeLimit: 1 * 1024 * 1024    // 50 M
        });
    </script>
@endsection
