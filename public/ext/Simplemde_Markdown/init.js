class MyMarkdown{
    constructor() {
        this.setting = {
            'textarea': {
                'id': 'markdown-editor',
            },
            'interval': true,
            'markdown': {
                element: document.getElementById('markdown-editor'),
                autoDownloadFontAwesome: false,
                spellChecker: false,
                /*autosave: {
                    enabled: true,
                    delay: 5000,
                    unique_id: "article_content_"
                },*/
                forceSync: true,
                tabSize: 4,
                toolbar: [
                    "bold", "italic", "heading", "|", "quote", "code", "table",
                    "horizontal-rule", "unordered-list", "ordered-list", "|",
                    "link", "image", "|", "side-by-side", 'fullscreen', "|",
                    {
                        // 自定义[ 发布话题 ]
                        name: "publish",
                        action: function customFunction(editor) {
                            $(editor.element).closest('form').eq(0).submit();
                        },
                        className: "fa fa-paper-plane",
                        title: "{{ isset($_markdown['publish_title']) ? $_markdown['publish_title'] : '发布文章' }}",
                    },
                    {
                        // 自定义[ 清楚缓存 ]
                        name: "publish",
                        action: function customFunction(editor) {
                            localStorage.clear();
                            localStorage.clear();
                            localStorage.clear();
                            localStorage.clear();
                            localStorage.clear();
                            localStorage.clear();
                            alert('清理完成');
                        },
                        className: "fa fa-trash",
                        title: "清除本地缓存",
                    },
                    {
                        // 自定义标签
                        name: "guide",
                        action: function customFunction(editor) {
                            var win = window.open('https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md', '_blank');
                            if (win) {
                                //Browser has allowed it to be opened
                                win.focus();
                            } else {
                                //Browser has blocked it
                                alert('Please allow popups for this website');
                            }
                        },
                        className: "fa fa-info-circle f_r",
                        title: "Markdown 语法！",
                    }
                ],
            },
            'uploadUrl': Config.routes.upload_image,
            'events': {
                change: function () {},
            }
        }

        /**
         * markdown 还原初始化
         * window['markdown_markdown-editor'].value('')
         */
    }

    init(opt){
        this.create($.extend(true, this.setting, opt));
    }

    create(setting){
        var self = this;
        if (document.getElementById(setting.textarea.id)) {
            $(document).ready(function () {
                self.initSimpleMDE(setting);
            });
        } else {
            console.error('必须先创建好 textarea DOM节点后才可以调用 `init` 方法')
        }
    }

    initSimpleMDE(setting){
        setting.markdown.element = document.getElementById(setting.textarea.id);
        var simplemde = window['markdown_' + setting.textarea.id] = new SimpleMDE(setting.markdown);

        if(setting.interval){
            var interval = setInterval(function () {
                if (simplemde.isFullscreenActive()) {
                    $('.duke-pulse.editor-fullscreen').hide();
                    $(window).trigger('resize');
                    clearInterval(interval);
                }
            }, 1000);
        }

        simplemde.codemirror.on("refresh", function () {
            $(window).trigger('resize');
        });
        simplemde.codemirror.on("paste", function () {
            $(window).trigger('resize');
        });
        simplemde.codemirror.on("change", function(){
            var markdown = simplemde.value();
            setting.events.change(simplemde.markdown(markdown));
        });

        // 图片上传
        inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, {
            uploadUrl: setting.uploadUrl,
            extraParams: {
                '_token': Config.token,
            },
            onFileUploadResponse: function(xhr) {
                var result = JSON.parse(xhr.responseText),
                    filename = result[this.settings.jsonFieldName];

                if (result && filename) {
                    var newValue;
                    if (typeof this.settings.urlText === 'function') {
                        newValue = this.settings.urlText.call(this, filename, result);
                    } else {
                        newValue = this.settings.urlText.replace(this.filenameTag, filename);
                    }
                    var text = this.editor.getValue().replace(this.lastValue, newValue);
                    this.editor.setValue(text);
                    this.settings.onFileUploaded.call(this, filename);
                }
                return false;
            }
        });
    }
}

window.MyMarkdown = MyMarkdown;
