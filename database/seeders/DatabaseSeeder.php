<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 设定假数据的生成顺序
     *
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(FollowersTableSeeder::class);

        Model::reguard();
    }
}
