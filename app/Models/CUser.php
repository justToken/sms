<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class CUser extends Model implements Transformable
{
    use ActionButtonTrait;
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *      
     * @var array
     */
    protected $fillable = [
        'sjhm', 'yhxm', 'zjlx',"zjhm","dzyx","qssj","zzsj","usergroup","khh","account","status"
    ];

      protected $table = 'users';

    public function Usergroup()
    {
        // 多对多的关系（一个角色赋予了多个用户）
        
        return $this->hasOne(Usergroup::class,"id","usergroup");
    }

}
