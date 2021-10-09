<?php

use Illuminate\Support\Facades\Route;
//这个web路由，没有单独定义每个路由的中间件，但是在kernel中定义了，所以会调用定义的中间件
/**
 *
   *     \App\Http\Middleware\TrustProxies::class,//信任的代理
 *       \Fruitcake\Cors\HandleCors::class,//没有详情说明是干嘛的，应该是对cors的处理 跨域资源共享
 *       \App\Http\Middleware\PreventRequestsDuringMaintenance::class,//不管
 *       \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,//验证post请求的数据大小，超限报错
*        \App\Http\Middleware\TrimStrings::class,//裁剪字符串，应该是把字符串前后空格去掉的
*        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,//把空字符转成null，这种都是看名称就能知道大概意思的，如果不懂就点进去看看，按着Ctrl，点击就会跳转
* 'web' => [
  *          //你现在用的web路由组，会默认调用下面的中间件，我看一下要不要到路由那里写了才会调用，不用，这里写了就是会调用这些中间件，从上往下顺序调用，先调用全局的$middleware里面的中间件，然后调用所用到的组里面的
 *           \App\Http\Middleware\EncryptCookies::class,//加密cookie
*            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,//添加队列cookie到返回数据 queue队列  response 返回
 *           \Illuminate\Session\Middleware\StartSession::class,//开启session
 *           // \Illuminate\Session\Middleware\AuthenticateSession::class,
 *           \Illuminate\View\Middleware\ShareErrorsFromSession::class,//从session中分享错误
 *           \App\Http\Middleware\VerifyCsrfToken::class,//csrf验证
 *           \Illuminate\Routing\Middleware\SubstituteBindings::class,
*        ],
*这些全部都会顺序调用，调用中间件是进入中间件类的handle方法进行处理
*/












Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup','UsersController@create')->name('signup');
Route::resource('users','UsersController');

Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');




Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');


Route::get('password/reset', 'PasswordController@showLinkRequestForm')->name('password.request');//填写Email的表单

Route::post('password/email','PasswordController@sendResetLinkEmail')->name('password.email');//处理表单提交，成功的话就发送邮件，附带Token的链接

Route::get('password/reset/{token}','PasswordController@showResetForm')->name('password.reset');//更新密码的表单，包括token
Route::post('password/reset','PasswordController@reset')->name('password.update');//对提交够来的token和email数据尽心配对，正确的话更新密码


Route::resource('statuses','StatusesController',['only'=>['store','destroy']]);//resource包括增删改查这四个路由，但这里只需要微博的创建和删除两个动作


Route::get('/users/{user}/followings',
'UsersController@followings')->name('users.followings');//用户关注者列表（关注了谁的表单）的路由
Route::get('/users/{user}/followers','UsersController@followers','UserController@followers')->name('users.followers');//用户粉丝列表（被谁关注的表单）的路由


Route::post('/users/follower/{user}','FollowersController@store')->name('followers.store');//关注功能
Route::delete('/users/follower/{user}','FollowersController@destroy')->name('followers.destroy');//取消关注



//五种请求方式 get post put  patch  delete
//查询用get 新增用post 更新用put 或者patch  删除用delete
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


