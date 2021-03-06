<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];




    public static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


public function gravatar($size = '100')
{
    $hash = md5(strtolower(trim($this->attributes['email'])));
    return "http://secure.gravatar.com/avatar/$hash?s=$size";

}


    public function statuses ()
    {
        return $this ->hasMany(Status::class);
    }

    //feed动态流方法，显示当前登录用户的个人微博状态，和关注人的微博动态数据
    public function feed()
    {
        //通过followings方法取出所有关注用户的信息，再借助pluck方法将id进行分离并赋值给user_id;pluck采摘
        $user_ids = $this->followings->pluck('id')->toArray();

        //将当前用户的id加入user_ids;
        array_push($user_ids,$this->id);

        //使用laravel提供的查询构造器whereIn方法取出所有用户的微博动态并进行倒序排序
        return Status::whereIn('user_id',$user_ids)
                        ->with('user')//这里使用了eloquent关联的预加载方法with方法，预加载避免了n+1查找问题，提高了查询效率
                        ->orderBy('created_at','desc');

    }

    //粉丝关系列表
    public function followers()
    {
        //belongsToMany(User:class,'自定义的表名称','定义在关联的模型外键名','要合并的模型外键名')
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }


    //用户关注列表
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }


    public function follow($user_ids)
    {
        //判断user_id是否是一个数组，如果不是，就用compact方法转化为数组
        if(! is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //用sync方法将对象加入关注列表
        $this->followings()->sync($user_ids,false);
    }


    public function unfollow($user_ids)
    {
        if( ! is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //detach方法可以将用户从关注列表里删除
        $this->followings()->detach($user_ids);
    }

//followings()和followings方法的区别

    //解释1
        // 1.返回的是一个HasMany对象
        // $this->followings();
        // 2.返回的是一个Collection集合
        // $this->followings;
        // 实质上等于$this->followings()->get();

    // 解释2
        // 因为 contains 方法是 Collection 类的一个方法，$this->followings 返回的是一个 Collection 类的实例，也就是一个集合，但是 $this->followings() 返回的是一个 Relations，没有 contains 方法，所以不能加括号。




    //判断当前用户a是否已经关注该用户b,并返回判断
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
