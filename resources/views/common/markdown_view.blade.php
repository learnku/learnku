{{-- 代码高亮工具 --}}
{{--<link rel="stylesheet" href="{{ asset_cdn('sass/vendor/markdown.scss') }}">--}}

<link rel="stylesheet" href="{{ assert_cdns('/ext/prism/prism.css') }}">
<link rel="stylesheet" href="{{ assert_cdns('/ext/jquery/jquery.tocify/jquery.tocify.css') }}">
<script src="{{ assert_cdns('/ext/prism/prism.js') }}"></script>
<script src="{{ assert_cdns('/ext/jquery/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ assert_cdns('/ext/jquery/jquery.tocify/jquery.tocify.min.js') }}"></script>

<script type="text/javascript">
    /** 代码高亮工具 */
    class MarkdownBody {
        constructor(){
            this.bodyClass = '.markdown-body';
            this.codeClass = '.markdown-body pre';
            this.addLineNumber();
            this.addThreePoints();
            this.addTitleNav();
        }

        /** 增加行号 */
        addLineNumber(){
            $(this.codeClass).addClass("line-numbers").css("white-space", "pre-wrap");
        }
        /** 增加 三个点 漂亮样式 */
        addThreePoints(){
            var html = '<div class="window-controls"><i class="red"></i><i class="yellow"></i><i class="green"></i></div>';
            $(this.codeClass).prepend(html);
        }
        /** 增加标题导航 tocify */
        addTitleNav(){
            var self = this;
            var selectors = ['h1', 'h2', 'h3', 'h4'];
            var selectorsTmp = [];
            selectors.forEach((item)=> {
                if ($(self.bodyClass).find(item).length > 0) {
                    selectorsTmp.push(item);
                }
            });
            if (selectorsTmp.length > 0) {
                selectorsTmp = selectorsTmp.join(', ');
            } else {
                selectorsTmp = '';
            }
            /**   #markdown-tocify   */
            $("#markdown-tocify").tocify({
                context: self.bodyClass,    // 任意可用的jQuery选择器
                selectors: selectorsTmp,    // 文章节点，可以关联生成目录
                showAndHide: false,         // 是否展示二级目录结构
                showEffect:'show',          // 目录展示效果："none", "fadeIn", "show", or "slideDown"
                hashGenerator: function (a,b) {
                    // 返回随机数
                    return Math.random().toString(36).substr(2,10);
                }
            });
        }
    }
    $(function () {
        new MarkdownBody();
    });
</script>
