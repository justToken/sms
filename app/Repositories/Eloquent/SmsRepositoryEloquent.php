<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\SmsRepository as SmsRepositoryInterface;
use App\models\Sms;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class SmsRepositoryEloquent extends BaseRepository implements SmsRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sms::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function ajaxIndex($request)
    {
        $draw            = $request->input('draw',1);
        $start           = $request->input('start',0);
        $length          = $request->input('length',10);
        $order['name']   = $request->input('columns.' .$request->input('order.0.column') . '.name');
        $order['dir']    = $request->input('order.0.dir','asc');
        $search['value'] = $request->input('search.value','');
        $search['regex'] = $request->input('search.regex',false);

        if ($search['value']){
            if ($search['regex'] == 'true'){
                $this->model = $this->model->where('dxbh','like',"%{$search['value']}%")->orWhere('desc','like',"%{$search['value']}%");
            }else{
                $this->model = $this->model->where('dxbh',$search['value'])->orWhere('desc',$search['value']);
            }
        }

        $count = $this->model->count();
        $this->model = $this->model->orderBy($order['name'],$order['dir']);
        $this->model = $this->model->offset($start)->limit($length)->get();

        if ($this->model) {
            foreach ($this->model as $item) {
                $item->button = $item->getActionButtons('sms');
                $item->name = $item->admin->toArray()['name'];//获取关联的角色
            }
        }

        return [
            'draw'              =>$draw,
            'recordsTotal'      =>$count,
            'recordsFiltered'   => $count,
            'data'              =>$this->model
        ];
    }

    public function createSms(array $attributes)
    {
        $rs = $this->findByField("dxbh",$attributes['dxbh'])->toArray();
        if(!empty($rs)){
            flash('短信编号重复','error');
            return -1;
        }
        $res = $this->model->create($attributes);

        if ($res){
            flash('新增成功','success');
        }else{
            flash('新增失败','error');
        }
        return $res;
    }

    public function getAll($columns = ['*'])
    {
        $res = $this->all($columns)->toArray();
        return $res;

    }

}
