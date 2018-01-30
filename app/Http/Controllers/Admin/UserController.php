<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\UserRepositoryEloquent as UserRepository;
use DB;
use App\Traits\Admin\WebSocketClientTrait;

class UserController extends Controller
{
    public $user;
    use WebSocketClientTrait;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('CheckPermission:user');
        $this->user = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usergroup = DB::table('usergroup')->get();
        return view('admin.user.create',compact('usergroup'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $this->user->createuser($data);
        $data = [
            'user'=>'系统',
            'avar'=>'a3.jpg',
            'msg'=>"尊敬的客户{$data['yhxm']},您已开通短信通功能!",
            'type'=> "4",
            'class_name'=>"chat-ta",
            'user_list' =>array($data['sjhm']),
        ];
        $data = json_encode($data);
        $this->connect("www.liverecord.cn", 8090,"/");
        $this->sendData($data);
        $this->disconnect();

        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $user = $this->user->find($id,['id','sjhm', 'yhxm', 'zjlx',"zjhm","dzyx","qssj","zzsj","usergroup","khh"])->toArray();
        
        $usergroup = DB::table('usergroup')->get();
        return view('admin.user.edit',compact('user','usergroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(userRequest $request, $id)
    {
        $res = $this->user->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = $this->user->find($id,['id','sjhm', 'yhxm', 'zjlx',"zjhm","dzyx","qssj","zzsj","usergroup","khh"])->toArray();
        
        $data = [
            'user'=>'系统',
            'avar'=>'a3.jpg',
            'msg'=>"尊敬的客户{$user['yhxm']},您已取消短信通功能!",
            'type'=> "4",
            'class_name'=>"chat-ta",
            'user_list' =>array($user['sjhm']),
        ];
        $data = json_encode($data);
        $this->connect("www.liverecord.cn", 8090,"/");
        $this->sendData($data);
        $this->disconnect();

        $res = $this->user->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/user');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->user->ajaxIndex($request);
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

    public function blacklist($id){
        
        if(is_null($id)){         
            return redirect('admin/user');
        }
        $id = (int)$id; 
        $user = $this->user->find($id,['id','sjhm', 'yhxm', 'zjlx',"zjhm","dzyx","qssj","zzsj","usergroup","khh","status"])->toArray();
        $data = array();
    
        if($user['status'] == 3){
            $data['status'] = 1;
        }else{
            $data['status'] = 3;
        }

        $res = $this->user->update($data,$id);
        return redirect('admin/user');
    }
}
