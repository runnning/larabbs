<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory,MustVerifyEmailTrait;
    use HasRoles;
    use Notifiable{
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果通知的人是当前用户,就不必通知了！
        if($this->id==Auth::id()){
            return;
        }
        //只有数据库类型通知才需要提醒,直接发送Email或者其他都Pass
        if(method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model): bool
    {
        return $this->id==$model->user_id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    //通知状态设为已读,并清空未读消息。
    public function markAsRead(){
        $this->notification_count=0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
