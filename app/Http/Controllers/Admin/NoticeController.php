<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\NoticeRepositoryEloquent as NoticeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use DB;
use App\Traits\Admin\WebSocketClientTrait;

class NoticeController extends Controller
{
    use WebSocketClientTrait;

    private $notice;

    public function __construct(NoticeRepository $NoticeRepository)
    {
        $this->middleware('CheckPermission:notice');
        $this->notice = $NoticeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $usergroup = DB::table('usergroup')->get();
        // return view('admin.notice.create',compact('usergroup'));
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(noticeRequest $request)
    {
       
        // $attr = $request->all();
        // $attr['admins_id'] = auth('admin')->user()->id;
        // $this->notice->createnotice($attr);
        // return redirect('admin/notice');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $notice = $this->notice->find($id,['id','content','admins_id','usergroup_id','desc'])->toArray();
        // $usergroup = DB::table('usergroup')->get();
        // return view('admin.notice.edit',compact('notice','usergroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(noticeRequest $request, $id)
    {
        // $res = $this->notice->update($request->all(),$id);
        // if ($res){
        //     flash('保存成功','success');
        // }else{
        //     flash('保存失败','error');
        // }
        // return redirect('admin/notice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $res = $this->notice->delete($id);
        // if ($res){
        //     flash('删除成功','success');
        // }else{
        //     flash('删除失败','error');
        // }
        // return redirect('admin/notice');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->notice->ajaxIndex($request);
        
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

    public function send($id){
        $message = $this->notice->find($id,['id','content','admins_id','usergroup_id','desc'])->toArray();
        var_dump($this->notice->update(['status'=>"1"],$id)->toSql());
        if($message['usergroup_id'] == 0){
           $user =  DB::table('users')->get();
        }else{
            $user = DB::table('users')->where('usergroup', $message['usergroup_id'])->get();
        }
        $user_id_lists = array();

        foreach($user as $v){
            $user_id_lists[] = $v->sjhm;
        }


        $data = [
            'user'=>'系统',
            'avar'=>'a3.jpg',
            'msg'=>$message["content"],
            'type'=> "4",
            'class_name'=>"chat-ta",
            'user_list' =>$user_id_lists
        ];
        $data = json_encode($data);
        $this->connect("www.liverecord.cn", 8090,"/");
        $this->sendData($data);
        $this->disconnect();
        flash('发送成功','success');
        return redirect('admin/notice');
    }

}
