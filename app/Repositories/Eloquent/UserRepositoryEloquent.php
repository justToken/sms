<?php

namespace App\Repositories\Eloquent;

use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;
use App\Models\CUser as User;
use Hash;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $order['name'] = $request->input('columns.' . $request->input('order.0.column') . '.name');
        $order['dir'] = $request->input('order.0.dir', 'asc');
        $search['value'] = $request->input('search.value', '');
        $search['regex'] = $request->input('search.regex', false);
        if ($search['value']) {
            if ($search['regex'] == 'true') {//传过来的是字符串不能用bool值比较
                $this->model = $this->model->where('sjhm', 'like', "%{$search['value']}%")->orWhere('zjhm', 'like', "%{$search['value']}%");
            } else {
                $this->model = $this->model->where('sjhm', $search['value'])->orWhere('zjhm', $search['value']);
            }
        }
        $count = $this->model->count();
        $this->model = $this->model->orderBy($order['name'], $order['dir']);
        $this->model = $this->model->offset($start)->limit($length)->get();

        if ($this->model) {
            foreach ($this->model as $item) {
                $item->button = $this->black_list($item->id,$item->status).$item->getActionButtons('user');
                $item->zjlx = $this->zjlx($item->zjlx);
                $item->groupname = $item->Usergroup->toArray()['name'];
            }
        }

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $this->model
        ];
    }

    public function createuser(array $attr)
    {
        $attr['account'] = rand(10,10000);
        $res = $this->model->create($attr);

        if ($res){
            flash('新增成功','success');
        }else{
            flash('新增失败','error');
        }
        return $res;
    }

    public function editViewData($id)
    {
        $user = $this->find($id, ['id', 'name', 'email']);
        $userRole = DB::table('role_admin')->where('user_id', $id)->first();
        if ($user) {
            return compact('user', 'userRole');
        }
        abort(404);
    }

    public function updateuser(array $attr, $id)
    {

        $res = $this->update($attr, $id);

        $userRole = DB::table('role_admin')->where('user_id', '=', $id)->first();
        if ($userRole) {
            DB::table('role_admin')->where('user_id', '=', $id)->update(['role_id' => $roleId]);
        } else {
            DB::table('role_admin')->insert(['user_id' => $id, 'role_id' => $roleId]);
        }
        if ($res) {
            flash('修改成功!', 'success');
        } else {
            flash('修改失败!', 'error');
        }
        return $res;
    }

    private function black_list($id,$status){
        if($status == 2){
            $html = "<a href='JavaScript:void(0)'><button type='button' class='btn btn-danger btn-xs'><i class='fa fa-paper-plane-o'>已经欠费</i></button></a> ";  
        }else{
            $html = "<a href='".url('admin').'/user/black/'.$id."'><button type='button' class='btn btn-".($status == 1?"primary":"warning")." btn-xs'><i class='fa fa-paper-plane-o'> ".($status == 1?"列入黑名单":"解除黑名单")."</i></button></a> ";
        }

        return $html;
    }

    //证件定义
    private function zjlx($type){
        $str = "";
        switch($type){
            case "0":
                $str = "身份证";
                break;
            case "1":
                $str = "居住证";
                break;
            case "2":
                $str = "护照";
                break;
            case "3":
                $str = "户口本";
                break;
            case "4":
                $str = "军人证";
                break;
            default:
                $str = "身份证";
        }
        return $str;
    }


}
