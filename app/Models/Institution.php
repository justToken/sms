<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;

class Institution extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    protected $table = 'institutions';
    protected $fillable = [
        'jgmc',
        'tel',
        'address'
    ];

}
