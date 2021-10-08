<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Status;

class StaticPagesController extends Controller
{
    public function home(){
        //定义一个空数组feed_items来保存微博动态数据
        $feed_items = [];
        //Auth::check()检查用户是否已登录
        if(Auth::check()){
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home',compact('feed_items'));
    }

    public function help(){
        return view('static_pages/help');
    }

    public function about(){
        return view('static_pages/about');
    }
}
