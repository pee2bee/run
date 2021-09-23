<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
/**
 * 这个登录认证类，继承了系统自带的一个验证类，所以可以直接用它老爸的方法 as 就是可以取别名，下面直接使用别名，本来是叫Authenticate 由于我们这个类也是叫Authenticate，所以就给老爸起了个别名middleware
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    //这个类是继承的，所以看他老爸的
}
