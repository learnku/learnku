
## API 模式下的用户认证
1. [Laravel 自带的 API 守卫驱动 token 使用详解](https://learnku.com/articles/11006/detailed-explanation-of-laravels-own-api-guard-drive-token)
2. [使用 Laravel Passport 实现 API 认证](https://laravelacademy.org/post/8298.html)
3. [基于 JWT 实现 Laravel API 认证](https://laravelacademy.org/post/9794.html)
4. [登录 API 获取 JWT 令牌](https://learnku.com/courses/laravel-advance-training/5.5/mobile-login-api/793)

## Api
1. [基于 Laravel 5.5 构建 & 测试 RESTful API](https://laravelacademy.org/post/9153.html)


## 代码生成器为我们做了哪些事情?
```
php artisan make:scaffold Topic --schema="title:string:index,body:text,user_id:integer:unsigned:index,......"
```
1. 创建话题的数据库迁移文件 —— 2018_12_23_104258_create_topics_table.php；
2. 创建话题数据工厂文件 —— TopicFactory.php；
3. 创建话题数据填充文件 —— TopicsTableSeeder.php；
4. 创建模型基类文件 —— Model.php， 并创建话题数据模型；
5. 创建话题控制器 —— TopicsController.php；
6. 创建表单请求的基类文件 —— Request.php，并创建话题表单请求验证类；
7. 创建话题模型事件监控器 TopicObserver 并在 AppServiceProvider 中注册；
8. 创建授权策略基类文件 —— Policy.php，同时创建话题授权类，并在 AuthServiceProvider 中注册；
9. 在 web.php 中更新路由，新增话题相关的资源路由；
10. 新建符合资源控制器要求的三个话题视图文件，并存放于 resources/views/topics 目录中；
11. 执行了数据库迁移命令 artisan migrate；
12. 因此次操作新建了多个文件，最终执行 composer dump-autoload 来生成 classmap。

## artisan 
```
// 重置数据库 ---------------------------------------------------
php artisan migrate:refresh --seed

// 博客分类 ---------------------------------------------------
php artisan make:scaffold BlogCategories --schema="name:string:index,description:text:nullable,post_count:integer:default(0),cascade:tinyInteger:default(0):index,user_id:integer:unsigned:index"

// 博客文章 ---------------------------------------------------
php artisan make:scaffold BlogArticles --schema="
title:string:index,
body:text,
user_id:integer:unsigned:index,
category_id:integer:unsigned:index,
reply_count:integer:unsigned:default(0),
view_count:integer:unsigned:default(0),
last_reply_user_id:integer:unsigned:default(0),
order:integer:unsigned:default(0),
excerpt:text:nullable,
slug:string:nullable"

// 博文回复 ---------------------------------------------------
php artisan make:scaffold BlogReply --schema="topic_id:integer:unsigned:default(0):index,user_id:integer:unsigned:default(0):index,content:text"


// 教程文章 ---------------------------------------------------
php artisan make:scaffold CourseArticles --schema="
// 充当目录
title:string:index,
body:text,
reply_count:integer:unsigned:default(0),
view_count:integer:unsigned:default(0),
slug:string:nullable,
// 书籍id
course_books_id:integer:unsigned:index,  
// 章节id
courses_section_id:integer:unsigned:index, 
user_id:integer:unsigned:index
"

// 教程章节 ---------------------------------------------------
php artisan make:scaffold CourseSections --schema="
title:string:index,
// 书籍id
course_books_id:integer:unsigned:index
"

// 教程书 ---------------------------------------------------
php artisan make:scaffold CourseBooks --schema="
title:string:index,
excerpt:text:nullable,
user_id:integer:unsigned:index
"


```
