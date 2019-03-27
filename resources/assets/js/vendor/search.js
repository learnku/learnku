/**
 * 全局搜索
 */

var app = new Vue({
  el: '#header-search-app',
  // 重新定义分解符
  delimiters: ['<{', '}>'],
  data: {
  	timmer: null,
    search_val: '',
    search_blog: []
  },
  methods: {
  	search($event){
  		this.timmer && clearTimeout(this.timmer);
  		this.timmer = setTimeout(()=>{
  			clearTimeout(this.timmer);
  			// todo
  			console.log();
  			let form = $($event.target).closest('form');
  			let action = form.attr('action');
  			let data = form.serialize();
  			axios({
  				method: 'get',
  				url: action,
  				data: data
  			}).then(res => {
  				console.log(res);
  				this.search_blog = res.data.data.blog
  			});
  		}, 500)
  	}
  }
})