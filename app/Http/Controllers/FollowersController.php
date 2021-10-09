<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    //中间件构造器
    public function _construct()
    {
        $this->middleware('auth');
    }

    //实现关注功能
    public function store(User $user)
    {
        //对用户进行授权判断，要求不能对自己进行关注和取消关注
        $this->authorize('follow',$user);



        //检查是否已经关注，未关注则用follow()方法关注
        if(!Auth::user()->isFollowing($user->id)){
            Auth::user()->follow($user->id);
        }
        
        //相当于刷新页面
        return redirect()->route('users.show',$user->id);
    }


    //实现关注功能
    public function destroy(User $user)
    {
        //对用户进行授权判断，要求不能对自己进行关注和取消关注
        $this->authorize('follow',$user);

        //检查是否已经关注，已关注则用unfollow()方法取消关注
        if( Auth::user()->isFollowing($user->id)){
            Auth::user()->unfollow($user->id);
        }

        //相当于刷新页面
        return redirect()->route('users.show',$user->id);
        }

}
