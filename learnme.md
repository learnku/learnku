
## API 模式下的用户认证
1. [Laravel 自带的 API 守卫驱动 token 使用详解](https://learnku.com/articles/11006/detailed-explanation-of-laravels-own-api-guard-drive-token)
2. [使用 Laravel Passport 实现 API 认证](https://laravelacademy.org/post/8298.html)
3. [基于 JWT 实现 Laravel API 认证](https://laravelacademy.org/post/9794.html)
4. [登录 API 获取 JWT 令牌](https://learnku.com/courses/laravel-advance-training/5.5/mobile-login-api/793)

## Api
1. [基于 Laravel 5.5 构建 & 测试 RESTful API](https://laravelacademy.org/post/9153.html)


## artisan 
```
// 重置数据库
php artisan migrate:refresh --seed

// 博客分类
php artisan make:scaffold BlogCategories --schema="name:string:index,description:text:nullable,post_count:integer:default(0),user_id:integer:unsigned:index"

```
