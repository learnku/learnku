@extends('layouts.app')
@section('title', $article->title ? $article->title : '实战教程')

@section('content')
    @include('shared._error')
    <div class="ui centered grid container stackable">
        <div class="sixteen wide column">
            <div class="ui segment">
                <a class="ui right corner label compose-help" href="javascript:;">
                    <i class="info icon"></i>
                </a>

                <div class="content extra-padding">
                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        @if($article->id)
                            <i class="icon paint brush"></i>编辑 <a href="{{ route('course.books.index', $book->id) }}">{{ $book->title }}</a> 文章
                        @else
                            <i class="icon paint brush"></i>新建 <a href="{{ route('course.books.show', $book->id) }}">{{ $book->title }}</a> 文章
                        @endif
                    </div>

                    @if($article->id)
                    <form id="article-update-form"
                          class="ui form"
                          style="min-height: 50px;"
                          action="{{ route('course.articles.update', [$book->id, $article->id]) }}" method="POST"
                          accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                    <form id="article-create-form"
                          style="min-height: 50px;"
                          class="ui form"
                          action="{{ route('course.articles.store', $data['book_id']) }}"
                          method="POST" accept-charset="UTF-8">
                    @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="field">
                            <label>教程
                                <a target="_blank" href="{{ route('course.books.index') }}">管理教程</a>
                            </label>
                            <div class="field">
                                <div class="ui fluid selection dropdown course_books_id_dropdown disabled">
                                    <input type="hidden" name="course_books_id"
                                           value="{{ old('course_books_id', $article->course_books_id ? $article->course_books_id : $data['book_id'] ? $data['book_id'] : '') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">请选择教程书籍（必选）</div>
                                    <div class="menu">
                                        <div class="item" data-value="{{ $book->id }}">
                                            {{ $book->title }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label>章节
                                <a target="_blank" href="{{ route('course.sections.index', $book->id) }}">管理章节</a>
                            </label>
                            <div class="field">
                                <div class="ui fluid selection dropdown course_section_id_dropdown">
                                    <input type="hidden" name="course_section_id"
                                           value="{{ old('course_section_id', $article->course_section_id) }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">请选择所属章节（必选）</div>
                                    <div class="menu">
                                        @foreach ($book->sections as $value)
                                            <div class="item" data-value="{{ $value->id }}">
                                                {{ $value->title }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label>收费</label>
                            <div class="field">
                                <div class="ui fluid selection dropdown course_section_id_dropdown">
                                    <input type="hidden" name="policy"
                                           value="{{ old('policy', $article->policy ? $article->policy : '0') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">是否收费（必选）</div>
                                    <div class="menu">
                                        <div class="item" data-value="0">免费</div>
                                        <div class="item" data-value="1">收费</div>
                                        <div class="item" data-value="2">限免</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label>标题</label>
                            <input class="form-control" type="text" name="title"
                                   id="title-field" value="{{ old('title', $article->title ) }}"
                                   placeholder="请填写标题" required="">
                        </div>


                        {{-- 加载 markdown 编辑器 --}}
                        <div class="markdown-base">
                                    <textarea
                                        id="markdown-editor"
                                        name="body"
                                        placeholder="请输入至少三个字符的内容。"
                                        rows="6">{{ old('body', $article->body ) }}</textarea>
                        </div>

                        <div contenteditable="true" id="pastebin"></div>

                        <div class="ui message">
                            <button type="submit" class="ui button primary publish-btn loading-on-clicked" id="">
                                <i class="icon send"></i>
                                发布文章
                            </button>

                            <a class="pull-right" href="/" target="_blank" style="color: #777;font-size: .9em;text-decoration: underline;margin-top: 8px;">
                                <i class="icon wpforms"></i> 编辑器使用指南
                            </a>
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
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            // 教程
            $('.course_books_id_dropdown').dropdown({
                allowAdditions: true,
                saveRemoteData: false,
                onChange: function (value, text, $selectedItem) {
                    console.info(value, text, $selectedItem);
                }
            });

            // 章节
            $('.course_section_id_dropdown').dropdown({
                allowAdditions: true,
                saveRemoteData: false,
                onChange: function (value, text, $selectedItem) {
                    console.info(value, text, $selectedItem);
                }
            });
        });
    </script>
@endsection
