<?php

namespace App\Http\Controllers;

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
}
