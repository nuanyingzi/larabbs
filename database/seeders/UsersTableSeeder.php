<?php

namespace Database\Seeders;

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
        //
        User::factory()->count(10)->create();

        $user = User::find(1);
        $user->name = "小天狼星";
        $user->email = "852947475@qq.com";
        $user->save();

        // 初始化角色，将1号用户指派为站长
        $user->assignRole('Founder');

        // 将2、3号用户指派为管理员
        $user = User::find(2);
        $user->assignRole('Maintainer');

        $user = User::find(3);
        $user->assignRole('Maintainer');
    }
}
