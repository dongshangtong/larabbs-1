<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据


	$avatars = [
            'https://pic.qqtn.com/up/2016-1/2016010609094834279.jpg',
            'https://pic.qqtn.com/up/2016-1/2016010609094856713.jpg',
            'https://pic.qqtn.com/up/2019-6/20196261429567172.jpg',
            'https://pic.qqtn.com/up/2016-1/2016010609094866462.jpg',
            'https://pic.qqtn.com/up/2016-1/2016010609094883288.jpg',
            'https://pic.qqtn.com/up/2019-8/2019080908525278969.jpg',
            'https://pic.qqtn.com/up/2016-1/2016010609094968044.jpg',
            'https://pic.qqtn.com/up/2016-1/2016010609094913163.png',
            'https://pic.qqtn.com/up/2016-1/2016010609094921444.jpg',
            'https://pic.qqtn.com/up/2019-8/2019080908525270688.jpg',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user, $index)
                            use ($faker, $avatars)
        {
            // 从头像数组中随机取出一个并赋值
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Summer';
        $user->email = 'summer@yousails.com';
        $user->avatar = 'https://pic.qqtn.com/up/2016-1/2016010609094819862.jpg';
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');

    }
}
