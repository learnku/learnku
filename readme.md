# 基于 Laravel 5.5 开发的个人项目

## 项目概述
* 产品名称：LearnKu
* 项目代号：learnku
* 官方地址：https://learnku.net

## 功能如下
* 特别说明 —— 除站长外其他用户仅允许发表评论
* 用户认证 —— 注册、登录、退出；
* 个人中心 —— 用户个人中心，编辑资料；
* 上传图片 —— 修改头像时候上传图片；
* 表单验证 —— 使用表单验证类；
* 多角色权限管理 —— 允许站长，管理员权限的存在；
* 后台管理 —— 后台数据模型管理；
* 站内通知 —— 文章有新回复；
* 自定义中间件 —— 记录用户的最后登录时间；
* XSS 安全防御；

## 运行环境要求
* Nginx 1.8+
* PHP 7.0+
* Mysql 5.7+
* Redis 3.0+

## 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.5](https://learnku.com/docs/laravel/5.5/) 开发，本地开发环境使用 [Laravel Homestead](https://learnku.com/docs/laravel/5.5/homestead)。
下文将在假定读者已经安装好了 Homestead 的情况下进行说明。如果您还未安装 Homestead，可以参照 [Homestead 安装与设置](https://learnku.com/docs/laravel/5.5/homestead#installation-and-setup) 进行安装配置。

### 基础安装

1. 克隆 larabbs 源代码到本地：
```
git clone git@github.com:GucciLee/learnku.git
```

2. 配置本地的 Homestead 环境
编辑 Homestead.yaml 文件, 修改如下：
```
folders:
    - map: ~/my-path/larabbs/ # 你本地的项目目录地址
      to: /home/vagrant/learnku

sites:
    - map: larabbs.test
      to: /home/vagrant/learnku/public

databases:
    - learnku
```

修改完成后保存，然后执行以下命令应用配置信息修改：
```
vagrant provision && vagrant reload
```

3. 安装扩展包依赖
```
composer install      	// 进入到项目目录
```

4. 生成配置文件
```
cp .env.example .env    // 进入到项目目录
```

5. 生成数据表及生成测试数据
```
$ php artisan migrate --seed
```

6. 生成秘钥
```
php artisan key:generate
```

7. 配置 hosts 文件
```
echo "192.168.10.10   learnku.test" | sudo tee -a /etc/hosts
```

### 前端框架安装
1). 安装 node.js 	// 直接去官网 https://nodejs.org/en/ 下载安装最新版本。

2). 安装 Yarn 		// 请安装最新版本的 Yarn —— http://yarnpkg.cn/zh-Hans/docs/install

3). 安装 Laravel Mix
```
yarn install
```

4). 编译前端内容
```
// 运行所有 Mix 任务...
npm run dev

// 运行所有 Mix 任务并缩小输出..
npm run production
```

5). 监控修改并自动编译
```
npm run watch

// 在某些环境中，当文件更改时，Webpack 不会更新。如果系统出现这种情况，请考虑使用 watch-poll 命令：

npm run watch-poll
```

### 链接入口
* 首页地址：http://learnku.test/

至此, 安装完成 ^_^。



## 扩展包使用情况
| 扩展包        | 一句话描述    |  本项目应用场景  |
| --------   | -----:   | :----: |
| [Intervention/image](https://github.com/Intervention/image)	|	图片处理功能库 | 	用于图片裁切 |
| [guzzlehttp/guzzle](https://github.com/guzzle/guzzle)	|	HTTP 请求套件 | 	请求百度翻译 API |
| [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)	|	页面调试工具栏 (对 phpdebugbar 的封装) | 	开发环境中的 DEBUG |
| [spatie/laravel-permission](https://github.com/spatie/laravel-permission)	|	角色权限管理 | 	角色和权限控制 |
| [mewebstudio/Purifier](https://github.com/mewebstudio/Purifier)	|	用户提交的 Html 白名单过滤 | 	文章内容的 Html 安全过滤，防止 XSS 攻击 |
| [viacreative/sudo-su](https://github.com/viacreative/sudo-su)	|	用户切换	 | 开发环境中快速切换登录账号 |
| [predis/predis](https://github.com/nrk/predis.git)	| Redis 官方首推的 PHP 客户端开发包 | 	缓存驱动 Redis 基础扩展包 |

## 自定义 Artisan 命令
| 命令行名字        | 说明    |  Cron  | 代码调用 |
| --------   | -----:   | :----: | :----: |

## 队列清单
| 名称        | 说明    |  调用时机  |
| --------   | -----:   | :----: |