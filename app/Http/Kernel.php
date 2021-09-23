<?php

namespace App\Http;

use App\Http\Middleware\TestMiddleware;//这里它自动帮我们引入了这个类
use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * 在类名上面的是类注释，使用xxxx来注释
 * 这个是http请求的内核类，kernel是内核的意思
 */
class Kernel extends HttpKernel
{
    /**
     *
     * 这里也是注释，是下面这个middleware属性的注释
     * 这里是应用的全局 http请求中间件的堆，就是说全部的http请求都会用到这几个中间件
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,//信任的代理
        \Fruitcake\Cors\HandleCors::class,//没有详情说明是干嘛的，应该是对cors的处理 跨域资源共享
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,//不管
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,//验证post请求的数据大小，超限报错
        \App\Http\Middleware\TrimStrings::class,//裁剪字符串，应该是把字符串前后空格去掉的
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,//把空字符转成null，这种都是看名称就能知道大概意思的，如果不懂就点进去看看，按着Ctrl，点击就会跳转
    ];

    /**
     * 这里是应用的路由中间件组，看结构，是一个数组，数组里面有两个元素，一个web，一个api
     * web就是网页前端是pc端浏览器的，这个就是你现在做的网页
     * api就是前端由其他框架来做，比如微信小程序，手机APP，前端就是由别的语言来做，后端只提供接口，提供数据
     * 这两个组对应的就是路由里面的web 和api文件
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            //你现在用的web路由组，会默认调用下面的中间件，我看一下要不要到路由那里写了才会调用，不用，这里写了就是会调用这些中间件，从上往下顺序调用，先调用全局的$middleware里面的中间件，然后调用所用到的组里面的
            \App\Http\Middleware\EncryptCookies::class,//加密cookie
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,//添加队列cookie到返回数据 queue队列  response 返回
            \Illuminate\Session\Middleware\StartSession::class,//开启session
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,//从session中分享错误
            \App\Http\Middleware\VerifyCsrfToken::class,//csrf验证
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     * 这里是定义全部中间件的，这里中间件可以放到上面的组里面，也可以单独使用
     * These middleware may be assigned to groups or used individually.
     * 就是说我们新增了一个中间件的类，需要到这里添加了才能使用
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'test' => TestMiddleware::class,//所以这里可以直接用类名，不用带命名空间，上面的那些就需要
    ];
}
