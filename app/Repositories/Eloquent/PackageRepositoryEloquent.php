<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PackageRepository as PackageRepositoryInterface;
use App\models\Package;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PackageRepositoryEloquent extends BaseRepository implements PackageRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Package::class;
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
                $item->button = $item->getActionButtons('package');
                $item->jfdy = $this->jfdy($item->jfdy);
                $item->sffs = $this->sffs($item->sffs);
                $item->jfts = $this->jffs($item->jfts);
                $item->mfdw = $this->mfdw($item->mfdw);
                // $item->groupname = $item->usergroup->toArray()['name'];

            }
        }

        return [
            'draw'              =>$draw,
            'recordsTotal'      =>$count,
            'recordsFiltered'   => $count,
            'data'              =>$this->model
        ];
    }


    public function createPackage(array $attributes)
    {
        
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
    //计费定义
    private function jfdy($type){
        $str = "";
        switch($type){
            case "0":
                $str = "按套餐";
                break;
            case "1":
                $str = "按短信类型";
                break;
            case "2":
                $str = "按套餐+短信类型";
                break;
            default:
                $str = "按套餐";
        }
        return $str;
    }
    //收费方式
    private function sffs($type){
        $str = "";
        switch($type){
            case "0":
                $str = "免费";
                break;
            case "1":
                $str = "包月";
                break;
            case "2":
                $str = "按条数";
                break;
            case "3":
                $str = "包月封顶";
                break;
            case "4":
                $str = "按条封顶";
                break;
            default:
                $str = "免费";
        }
        return $str;
    }
    //计费方式
    private function jffs($type){
        $str = "";
        switch($type){
            case "0":
                $str = "下行";
                break;
            case "1":
                $str = "上行";
                break;
            case "2":
                $str = "下行-上行";
                break;
            case "3":
                $str = "下行+上行";
                break;
            default:
                $str = "下行";
        }
        return $str;
    }

    //免费方式
    private function mfdw($type){
        $str = "";
        switch($type){
            case "0":
                $str = "天";
                break;
            case "1":
                $str = "月";
                break;
            case "2":
                $str = "年";
                break;
            default:
                $str = "天";
        }
        return $str;
    }

}
