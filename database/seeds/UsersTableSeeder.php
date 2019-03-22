<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // `factory(User::class)` 根据指定的 `User` 生成模型工厂构造器，对应加载 `UserFactory.php` 中的工厂设置
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index) use ($faker) {
                // ...
            });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_arrya = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_arrya);

        // 单独处理第一个用户数据
        $user = User::find(1);
        $user->name = '大黄蜂';
        $user->email = 'guccilee@163.com';
        $user->save();

        // 联动更新 user_infos 表
        foreach (User::all() as $user){
            $user_id = $user->id;
            \App\Models\UserInfo::insert([
                'user_id' => $user_id,
            ]);
        }
    }
}
