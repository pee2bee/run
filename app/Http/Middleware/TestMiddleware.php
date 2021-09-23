<?php

namespace App\Http\Middleware;

/**
 * 创建一个类，类名需要跟文件名称一致，这样才可以自动加载文件
 * 类名的命名格式 大驼峰 就是首字母大写，每个单词首字母都大小
 * 属性的命名方式 小驼峰 首字母小写，后面每个单词首字母大写
 * 方法的命名跟属性一致
 */
class TestMiddleware
{
    /**
     * 这里定义了一个中间件，到kernel中声明一下才能使用
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    /**
     * 属性命名
     */
    protected $getSomeParams;

    /**
     * 方法命名
     */
    public function howOld(){

    }
}
