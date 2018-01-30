<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\SmsRepositoryEloquent as SmsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SmsRequest;

class SmsController extends Controller
{
    private $sms;

    public function __construct(SmsRepository $smsRepository)
    {
        $this->middleware('CheckPermission:sms');
        $this->sms = $smsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sms.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SmsRequest $request)
    {
       
        $attr = $request->all();
        $attr['czyh'] = auth('admin')->user()->id;
        $this->sms->createSms($attr);
        return redirect('admin/sms');
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
        $sms = $this->sms->find($id,['id','mbnr','desc','dxbh'])->toArray();
        return view('admin.sms.edit',compact('sms'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SmsRequest $request, $id)
    {
        $res = $this->sms->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/sms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->sms->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/sms');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->sms->ajaxIndex($request);
        
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

}
