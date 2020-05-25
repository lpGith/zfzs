<?php

use App\Model\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空数据表
        User::truncate();

        //添加50条模拟数据
        factory(User::class, 50)->create();

        //规定id=1的用户为管理员
        User::where('id', 1)->update(['username' => 'admin']);

    }
}
