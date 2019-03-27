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
                        @if($category->id)
                            <i class="icon paint brush"></i>编辑 {{ $category->name }} 分类
                        @else
                            <i class="icon paint brush"></i>新建分类
                        @endif
                    </div>

                    @if($category->id)
                        <form id="category-update-form"
                              class="ui form"
                              style="min-height: 50px;"
                              action="{{ route('blog.categories.update', $category->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                    @else
                        <form id="category-create-form"
                              style="min-height: 50px;"
                              class="ui form"
                              action="{{ route('blog.categories.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="field">
                                <label>名称</label>
                                <input class="form-control" type="text" name="name"
                                       id="title-field" value="{{ old('name', $category->name ) }}"
                                       placeholder="请填写分类名称" required="">
                            </div>

                            <div class="field">
                                <label>描述</label>
                                <input class="form-control" type="text" name="description"
                                       id="title-field" value="{{ old('description', $category->description ) }}"
                                       placeholder="请填写分类描述">
                            </div>


                            <div class="field">
                                <label>
                                    上级分类（分类归属）
                                </label>
                                <div class="field">
                                    <div class="ui fluid selection dropdown">
                                        <input type="hidden" name="cascade" value="{{ $category->cascade }}">
                                        <i class="dropdown icon"></i>
                                        <div class="default text">请选择分类标签（必选）</div>
                                        <div class="menu">
                                            <div class="item" data-value="0">
                                                顶级分类
                                            </div>
                                            @foreach ($categories as $value)
                                                <div class="item" data-value="{{ $value->id }}">
                                                    {{ $value->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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
