<style>
    .CodeMirror, .CodeMirror-scroll {
        min-height: 160px !important;
    }
    .markdown-base{
        margin-bottom: 1em;
    }
</style>

{{-- 发表回复 --}}
<div class="ui threaded comments comment-list ">
    <br>
    <div class="ui segment extra-padding comment-composing-box pt-3" style="padding:20px;margin-left:60px">
        <div class="reply ui message hide"></div>
        <form class="ui reply form topic-reply-form"
              onsubmit="return false;"
              method="POST"
              action="{{ route('api.blog.replies.store') }}"
              accept-charset="UTF-8"
              id="comment-composing-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="article_id" value="{{ $article->id }}">

            <div class="ui message info">
                <i class="icon info" aria-hidden="true"></i>
                请勿发布不友善或者负能量的内容。与人为善，比聪明更重要！
            </div>

            {{-- 回复框 --}}
            <div class="markdown-base">
                @include('common.markdown_edit')
                <textarea
                    id="markdown-editor"
                    name="content"
                    placeholder="分享你的见解~"
                    rows="3"></textarea>
            </div>

            {{-- 评论 --}}
            <div class="field rm-link-color">
                <div class="pull-left meta">
                    <a href="javascript:;" class="mr-2 ui popover text-mute" data-html="黏贴或拖拽图片至输入<br>框内皆可上传图片">
                        <i class="icon picture"></i>
                    </a>
                    <a href="javascript:;" class="mr-2 ui popover text-mute" data-html="支持除了 H1~H6 以外的<br>GitHub 兼容 Markdown">
                        支持 MD
                    </a>
                </div>

                <div class="pull-right">
                    <button class="ui primary labeled icon button  no-loading"
                            type="submit" id="comment-composing-submit">
                        <i class="icon comment"></i> 评论
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>

        <div class="clearfix"></div>
        {{-- 评论预览 --}}
        <div class="box preview markdown-reply fluidbox-content" id="preview-box" style="display: none;border: dashed 1px #ccc;background: #ffffff;border-radius: 6px;box-shadow:none;margin-top: 20px;margin-bottom: 6px;"></div>
    </div>
</div>
