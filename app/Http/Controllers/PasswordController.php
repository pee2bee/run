<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:3,10',[
            'only' => ['showLinkRequestForm']
        ]);
    }

    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        //1.验证邮箱
        $request->validate(['email'=>'required|email']);
        $email = $request->email;

        //2.获取对应用户
        $user = User::where("email",$email)->first();

        //3.如果不存在
        if(is_null($user)){
            session()->flash('danger','邮箱未注册');
            return redirect()->back()->withInput();
        }

        //4.生成Token，会在视图emails.reset_link里拼接链接
        $token = hash_hmac('sha256',Str::random(40),config('app.key'));

        //5.入库，使用updateOrInsert 来保持Email唯一
        DB::table('password_resets')->updateOrInsert(['email'=>$email],[
            'email'=>$email,
            'token'=>Hash::make($token),
            'created_at'=>new Carbon,
        ]);

        //6.将Token链接发送给用户
        Mail::send('emails.reset_link',compact('token'),function($message) use ($email)
        {
            $message->to($email)->subject("忘记密码");
        });

        session()->flash('success','重置邮件发送成功，请查收');
        return redirect()->back();
    }

    public function showResetForm(Request $request)
    {
        $token=$request->route()->parameter('token');
        return view('auth.passwords.reset',compact('token'));
    }
    /**
     *
     */
    public function reset(Request $request)
    {
        //1,验数据
        //1.验证数据是否合规
        $request->validate([
            'token'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed|min:6',
        ]);
            $email = $request->email;
            $token = $request->token;
            //找回密码链接的有效期限
            $expires = 60 * 10;

        //2.获取对应的用户
        $user = User::where("email",$email)->first();

        //3.如果不存在
        if(is_null($user))
        {
            session()->flash('danger','邮箱不存在');
            return redirect()->back()->withInput();
        }

        //4.读取重置记录
        //查询构造器
        //mysqli
        //查询构造器  DB::table('users') 增删改查
        //模型
        $sql = DB::table('password_resets')->where('email',$email);//(array) 之后一定要

        $record = $sql->first();//有空格不然会出错

        //5.如果记录存在
        if($record)
        {
            //5.1检查是否过期
            if(Carbon::parse($record['created_at'])->addSeconds($expires)->isPast())
            {
                session()->flash('danger','链接已过期，请重新验证');
                return redirect()->back();
            }

            // 5.2. 检查是否正确
            if ( ! Hash::check($token, $record['token'])) {
                session()->flash('danger', '令牌错误');
                return redirect()->back();
            }

            //5.3一切正常，更新用户密码
            $user->update(['password'=>bcrypt($request->password)]);

            //5.4提示用户更新成功
            session()->flash('success','密码更新成功，请用新密码重新登录');
            return redirect()->route('login');
        }

        //6.未找到记录
        session()->flash('danger','未找到重置记录');
        return redirect()->back();
    }

















}

