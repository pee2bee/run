<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Auth;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    //构造中间件
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this -> validate($request,[
            'content' => 'required|max:140'
        ]);//限制微博内容不为空且不超过140字

        Auth::user()->statuses()->create([
            'content'=>$request['content']
        ]);
        //为啥不干脆这样写
        // Auth::user()->statuses()->create([
        //     'content'=>$request['content'],
        //     'content'=>'required|max:140'
        // ]);
        session()->flash('success','发布成功！');
        return redirect()->back();
    }



    //这里用（隐形路由模型绑定）功能，laravel会自动查找并注入对应id的实例对象，找不到就会抛出异常
    public function destroy(Status $status)
    {
        //做删除授权的检测，不通过会抛出403异常
        $this->authorize('destroy',$status);

        //调用Eloquent模型的delete方法对该微博进行删除
        $status->delete();
        
        session()->flash('success','微博已被成功删除!');
        return redirect()->back();
    }
}
