<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    //use SoftDeletes;
    protected $table = 'tc';
    //protected $dates = ['deleted_at'];
    protected $fillable = [
        "tcdm",
        "jgbm",
        "tcmc",
        "jfdy",
        "sffs",
        "byyz",
        "jfts",
        "mfdw",
        "mfsj",
        "status",
    ];

    public function admin()
    {
        // 多对多的关系（一个角色赋予了多个用户）
        return $this->hasOne(Admin::class,'id','admins_id');
    }

    public function usergroup()
    {
         return $this->hasOne(Usergroup::class,'id','usergroup_id');
    }

}
