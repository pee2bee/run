<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     *使用第一个用户对除自己以外的用户进行关注，再让其他用户都关注第一个用户
     */
    public function run()
    {
        //获取第一个用户的id
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //获取除1号用户外的其他用户的id数组
        $followers = $users -> slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //关注除了1号外的其他用户
        $user -> follow($follower_ids);

        //其他用户都来关注1号
        foreach($followers as $follower){
            $follower -> follow($user_id);
        }


    }



















}
