/**
 * 全局搜索
 */

var app = new Vue({
    el: '#header-search-app',
    // 重新定义分解符
    delimiters: ['<{', '}>'],
    data: {
        timmer: null,
        loading: false,
        search_blog_results: [],
        form: {
            search_type: 'is_blog',
            q: ''
        }
    },
    methods: {
        search($event) {
            this.timmer && clearTimeout(this.timmer);
            this.timmer = setTimeout(() => {
                clearTimeout(this.timmer);
                // todo
                let form = $($event.target).closest('form');
                let action = form.attr('action');
                this.loading = true;
                if ($.trim(this.form.q) != '') {
                    axios({
                        method: 'get',
                        url: action,
                        params: this.form
                    }).then(res => {
                        this.loading = false;
                        this.search_blog_results = res.data.data.blog
                    });
                } else {
                    this.loading = false;
                    // this.search_blog_results = [];
                }
            }, 200)
        }
    }
});
