@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="ui centered grid container stackable" style="width: 1300px !important;">
        <div class="wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1><i class="bell outline icon"></i> 七牛图片库
                        <button id="upload-images">上传图片</button>
                    </h1>
                    <div class="ui divider mb-0"></div>

                    {{-- 图片列表 --}}
                    <div class="ui cards"
                         style="margin-top: 20px;">
                        @foreach($images as $img)
                            @if(strpos($img['mimeType'], 'image') === false)
                            @else
                                <div class="ui card"
                                     data-key="{{ $img['key'] }}"
                                     data-hash="{{ $img['hash'] }}"
                                     data-fsize="{{ $img['fsize'] }}"
                                     data-mimeType="{{ $img['mimeType'] }}"
                                     data-putTime="{{ $img['putTime'] }}"
                                     data-type="{{ $img['type'] }}"
                                     data-status="{{ $img['status'] }}">
                                    <div class="image">
                                        <img class="lazy" data-original="{{ assert_images($img['key'], true) }}" style="max-height: 200px;cursor: pointer;">
                                    </div>
                                    <div class="extra content">
                                        <div class="ui two buttons">
                                            <div class="ui basic green button update">替换</div>
                                            <div class="ui basic red button delete">删除</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ assert_cdns('/ext/masonry/masonry.pkgd.min.js') }}"></script>
    <script type="text/javascript">
        // 展示大图
        $('.ui.cards img').click(function () {
            let src = $(this).attr('src');
            let img = new Image();
            img.src = src;
            let imageHeight = img.height;
            Swal.fire({
                imageUrl: src,
                imageHeight: imageHeight ? imageHeight : 200,
                imageAlt: 'A tall image'
            })
        });
        // 替换图片
        $('.ui.cards .update').click(function () {
            let box = $(this).closest('.card');
            new MyUploadOne({
                'url': "{{ route('api.images.update') }}",
                'method': 'post',
                'action': 'update',
                'file_type': 'qiniu',
                'path': box.attr('data-key'),
                success: function (res) {
                    Swal.fire(
                        '替换成功 ~',
                        'success'
                    )
                }
            });
        });
        // 删除图片
        $('.ui.cards .delete').click(function () {
            Swal.fire({
                title: '确定要删除吗 ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '是的, 删除它'
            }).then((result) => {
                if (result.value) {
                    let box = $(this).closest('.card');
                    new MyUploadOne({
                        'url': "{{ route('api.images.update') }}",
                        'method': 'post',
                        'action': 'delete',
                        'file_type': 'qiniu',
                        'path': box.attr('data-key'),
                        success: function (res) {
                            Swal.fire(
                                '删除成功 ~',
                                'success'
                            )
                        }
                    });
                }
            })
        });

        // 上传图片
        $("#upload-images").click(function () {
            new MyUploadOne({
                'file_type': 'qiniu',
                success: function (res) {
                }
            });
        });
    </script>
@endsection
