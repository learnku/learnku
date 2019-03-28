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
        // 提交数据
        form: {
            search_type: 'is_blog',
            q: ''
        },
        // 全局搜索
        search_all_url: Config.routes.search,
        // 搜索结果
        search_blog_results: [],
    },
    methods: {
        search($event) {
            this.timmer && clearTimeout(this.timmer);
            this.timmer = setTimeout(() => {
                clearTimeout(this.timmer);
                // todo
                let form = $($event.target).closest('form');
                let action = form.attr('data-api');
                this.search_all_url = this.search_all_url + '?' + form.serialize();

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
