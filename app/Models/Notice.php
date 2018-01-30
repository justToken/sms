<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    //use SoftDeletes;
    protected $table = 'dxmb';
    //protected $dates = ['deleted_at'];
    protected $fillable = [
        'czyh',
        'desc',
        'dxbh',
        'mbnr',    
    ];

    public function admin()
    {
        // 多对多的关系（一个角色赋予了多个用户）
        return $this->hasOne(Admin::class,'id','czyh');
    }

}
