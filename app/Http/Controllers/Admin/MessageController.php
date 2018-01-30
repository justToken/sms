<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\MessageRepositoryEloquent as MessageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use DB;

class MessageController extends Controller
{
    private $message;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->middleware('CheckPermission:message');
        $this->message = $messageRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.message.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usergroup = DB::table('usergroup')->get();
        return view('admin.message.create',compact('usergroup'));
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(messageRequest $request)
    {
       
        $attr = $request->all();
        $attr['admins_id'] = auth('admin')->user()->id;
        $this->message->createmessage($attr);
        return redirect('admin/message');
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
        $message = $this->message->find($id,['id','content','admins_id','usergroup_id','desc'])->toArray();
        $usergroup = DB::table('usergroup')->get();
        return view('admin.message.edit',compact('message','usergroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(messageRequest $request, $id)
    {
        $res = $this->message->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->message->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/message');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->message->ajaxIndex($request);
        
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

}
