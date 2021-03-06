<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except'=>['show','create','store','index','confirmEmail']
        ]);

        $this->middleware('guest', [
            'only'=>['create']
        ]);

        //限流，一个小时内只能提交10次请求,：然后是参数
        $this -> middleware('throttle:10,60',[
            'only' => ['store']
        ]);

    }


    public function create()
    {
        return view('users.create');
    }


    public function show(User $user)
    {
        $statuses = $user->statuses()
                        ->orderBy('created_at','desc')
                        ->paginate(10);
        return view('users.show', compact('user','statuses'));
    }

    public function store(Request $request)
    {
        // dd('调用创建用户');//现在是请求到了这个方法
        //调试使用dd() 就是vardump(); die;dd是laravel独有的，
        // var_dump('建用户');//打印信息
        // die;//打断请求，直接退出
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),//这里就是laravel自带的加密方法，使用的是对称加密，就是说是可以解密的
        ]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }



    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6',
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);//更新也做加密了
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功');

        return redirect()->route('users.show', $user);
    }


    public function index()
    {
        $users = User::paginate(6);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        //刚开始写代码，最好都加上注释
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户!');
        return back();
    }


    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 run 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ( $to, $subject) {
            $message->to($to)->subject($subject);
        });
    }



    public function confirmEmail($token)
    {

        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }


    //显示用户关注的人的列表
    public function followings(User $user)
    {
        //获取所有关注对象的数据$users,并分页显示
        $users = $user->followings()->paginate(30);
        //设计标题
        $title = $user->name.'关注的人';
        //返回统一视图users.show_follow，并加密传输关注的人和标题数据
        return view('users.show_follow',compact('users','title'));
    }

    //显示关注用户的粉丝的列表，逻辑跟以上followings方法差不多，并且共用一个视图users.show_follow
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name.'的粉丝';
        return view('users.show_follow',compact('users','title'));
    }

}


