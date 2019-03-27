
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap_learnku');

/** 返回对应位置 */
window.scrollToAnchor = function(id) {
    var e = $("*[id='" + id + "']");
    $("html,body").animate({
        scrollTop: e.offset().top
    }, "slow")
};

// 七牛 images 镜像
window.assert_images = function (path) {
    return Config.routes.images_domain + path;
};

// 全局公用函数
window.public = {
    axios_then: function (res) {
        Swal.fire({
            type: 'success',
            title: res.msg,
        });
    },
    axios_catch: function(error) {
        let response = error.response,
            html = '';
        if (response.data && response.data.errors) {
            for (let error in response.data.errors) {
                html += '<p style="text-align: left;">' + response.data.errors[error] + '</p>';
            }
            Swal.fire({
                type: 'error',
                html: html,
                showConfirmButton: false,
                showCancelButton: true
            });
        } else if(response.data && response.data.message){
            Swal.fire({
                type: 'error',
                text: response.data.message,
                showConfirmButton: false,
                showCancelButton: true
            });
        }else {
            // 回调
            self.setting.error(error);
        }
    },
};

class Learnku {
    init() {
        this.initSubmitBtn();
        this.closeMessage();
        this.initSematicUI();
        this.initLazyload();
        this.initDeleteForm();
        // this.axiosDeleteForm();
    }

    /** 表单提交 */
    initSubmitBtn(){
        $('button.ui.button[type="submit"]:not(.no-loading)').click(function() {
            $(this).addClass("disabled");
            if($(".clear-submit").length > 0) {
                var self = $(this);
                setTimeout(function() {
                    self.after('<a class="clear-submit ml-3 ts-small" href="javascript:;">清除加载状态</a>')
                }, 3000)
            }
        });

        $("body").on("click", "a.clear-submit", function() {
            $(this).siblings('button.ui.button[type="submit"]').removeClass("loading"),
                $(this).siblings('button.ui.button[type="submit"]').removeClass("disabled"),
                $(this).remove()
        })
    }

    /** 关闭 message 提示消息 */
    closeMessage() {
        $('.message .close').on('click', function () {
            $(this).closest('.message').transition('fade');
        });
    }

    /** SematicUI */
    initSematicUI(){
        $(".ui.dropdown").dropdown();
        $(".ui.community-nav.dropdown").dropdown({
            onChange: function(t, e, n) {
                window.location.href = n.attr("href")
            }
        });
        $(".ui.checkbox").checkbox();
        $(".ui.accordion").accordion();
        $(".ui.toc.sticky").sticky({
            silent: true,
            debug: true,
            context: ".article-content"
        });
        $(".ui.topic-operation.sticky").sticky({
            silent: !0,
            context: ".main-column"
        });
        $(".ui.translate-box.sticky").sticky({
            silent: !0
        });
        $(".ui.popover").popup({
            on: "hover",
            position: "top center"
        });
        $(".message .close").on("click", function() {
            $(".message-container").transition("fade")
        });
        $(".ui.left.sidebar").sidebar({
            transition: "overlay",
            mobileTransition: "uncover",
            observeChanges: !0,
            closable: !1,
            dimPage: !1,
            onVisible: function() {
                var e = 200 / screen.width * 100
                    , n = 100 - e + "%";
                $(".pusher").width(n),
                    $(".pusher").animate({
                        marginLeft: e + "%"
                    }, 400)
            },
            onShow: function() {
                $(".fixed.launch.button").css("left", 200),
                    $(".fixed.launch.button").css("padding", "10px 6px"),
                    $(".ui.toc.sticky").sticky("refresh")
            },
            onHide: function() {
                $(".pusher").width("100%"),
                    $(".pusher").css("margin-left", "inherit"),
                    $(".ui.toc.sticky").each(function() {
                        $(this).data("moduleSticky").refresh()
                    }),
                    $(".fixed.launch.button").css("padding", "0.78571429em 1.5em 0.78571429em"),
                    $(".fixed.launch.button").css("left", 0)
            },
            onHidden: function() {
                $(".ui.toc.sticky").sticky("refresh")
            }
        }).sidebar("attach events", ".launch.button, .chapter-title, .launch.item");
        $(".ui.top.sidebar").sidebar({
            transition: "overlay",
            mobileTransition: "uncover"
        }).sidebar("attach events", ".item.header.right.menu");
        $(".ui.progress").progress();

        // 选项页
        $('.menu .item').tab()
    }

    /** 懒加载*/
    initLazyload(){
        // <img class="lazy" data-original="img/corvette_pitstop.jpg">
        $("img.lazy").lazyload({
            // placeholder
        });
    }

    /** 删除 form 表单 */
    initDeleteForm(){
        $("[data-method]").append(function() {
            return `
                <form action="${$(this).attr("data-url")}" method='POST' style='display:none'>
                    <input type='hidden' name='_method' value="${$(this).attr("data-method").toUpperCase()}">
                    <input type='hidden' name='_token' value="${Config.token}">
                </form>
            `;
        }).css("cursor", "pointer").click(function () {
            var self = this;
            var e = $(this);
            var method = e.attr("data-method").toUpperCase();
            if("DELETE" == method){
                Swal.fire({
                    title: "",
                    html: $(self).attr("data-hint") ? $(self).attr("data-hint") : "你确定要删除此内容吗？",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "取消",
                    confirmButtonText: "删除"
                }).then(function(res) {
                    if(res.value){
                        e.find("form").submit()
                    }
                })
            }else if("POST" != method && "GET" != method || (e.attr("data-prompt"))){
                Swal.fire({
                    title: "",
                    html: $(self).attr("data-prompt"),
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "取消",
                    confirmButtonText: "确定"
                }).then(function(res) {
                    if(res.value){
                        e.find("form").submit()
                    }
                })
            }
        });
    }

    /** 删除 form 表单 2*/
    axiosDeleteForm(callback = null) {
        $("[axios-method]").css("cursor", "pointer").click(function () {
            let self = this;
            let method = $(this).attr("axios-method").toUpperCase();
            if("DELETE" == method){
                Swal.fire({
                    title: "",
                    html: $(self).attr("data-hint") ? $(self).attr("data-hint") : "你确定要删除此内容吗？",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "取消",
                    confirmButtonText: "删除"
                }).then(function(res) {
                    axios({
                        url: $(self).attr('data-url'),
                        method: method
                    }).then((res)=> {
                        if (callback) {
                            callback(self, res);
                        }
                        Swal.fire({
                            type: 'success',
                            title: '删除成功 . . .',
                        });
                    })
                })
            }else if("POST" != method && "GET" != method || (e.attr("data-prompt"))){
                /*Swal.fire({
                    title: "",
                    html: $(self).attr("data-prompt"),
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "取消",
                    confirmButtonText: "确定"
                }).then(function(res) {
                    if(res.value){
                        e.find("form").submit()
                    }
                })*/
            }
        })
    }
}


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
            theme: '',
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

/** 代码调用 ******************************************************/
// 代码高亮工具
new MarkdownBody();
// 基础代码
window.LearnkuNew = new Learnku();
LearnkuNew.init();
