@extends('layouts.app')

@section('content')
    @include('shared._error')
    <div class="ui centered grid container stackable">
        <div class="twelve wide column">
            <div class="ui segment">
                <a class="ui right corner label compose-help" href="javascript:;">
                    <i class="info icon"></i>
                </a>

                <div class="content extra-padding">

                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        @if($book->id)
                            <i class="icon paint brush"></i>编辑 {{ $book->title }}
                            <a href="{{ route('course.books.index') }}">教程</a>
                        @else
                            <i class="icon paint brush"></i>新建
                            <a href="{{ route('course.books.index') }}">教程</a>
                        @endif
                    </div>

                    @if($book->id)
                        <form id="category-update-form"
                              class="ui form"
                              style="min-height: 50px;"
                              action="{{ route('course.books.update', $book->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                    @else
                        <form id="category-create-form"
                              style="min-height: 50px;"
                              class="ui form"
                              action="{{ route('course.books.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="field">
                                <label>名称</label>
                                <input class="form-control" type="text" name="title"
                                       id="title-field" value="{{ old('title', $book->title ) }}"
                                       placeholder="请填写教程名称" required="">
                            </div>

                            <div class="field">
                                <label>简介</label>
                                {{-- 加载 markdown 编辑器 --}}
                                <div class="markdown-base">
                                <textarea
                                    id="markdown-editor"
                                    name="excerpt"
                                    placeholder="请填写教程简介。"
                                    rows="6">{{ old('excerpt', $book->excerpt ) }}</textarea>
                                </div>
                            </div>

                            {{-- 封面 --}}
                            <div class="field">
                                <label>封面</label>
                                <input type="hidden" name="image_id" value="{{ old('image_id', $book->image_id) }}">
                                <img id="upload-img"
                                     class="upload-img image-border ui popover"
                                     data-variation="inverted"
                                     data-content="【点击我】上传图片吧"
                                     src="{{ assert_images($book->image['path']) }}" width="320">
                            </div>

                            <div contenteditable="true" id="pastebin"></div>

                            <div class="ui message">
                                <button type="submit" class="ui button primary publish-btn loading-on-clicked" id="">
                                    <i class="icon send"></i>
                                    保存
                                </button>
                            </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('common.markdown_edit')
    <script type="text/javascript">
        var markdown = new Markdown();
        markdown.init({
            'textarea': {
                'id': 'markdown-editor',
            }
        });

        // 封面上传
        $("#upload-img").click(function () {
            let self = this;
            new MyUploadOne({
                'file_type': 'course',
                success: function (res) {
                    let path = assert_images(res.data.path);
                    $(self).attr('src', path);
                    $(self).closest('form').find("input[name='image_id']").val(res.data.id);
                }
            });
        });
    </script>
@endsection
