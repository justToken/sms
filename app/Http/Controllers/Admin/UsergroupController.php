<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\UsergroupRepositoryEloquent as UsergroupRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsergroupRequest;

class UsergroupController extends Controller
{
    private $usergroup;

    public function __construct(UsergroupRepository $usergroupRepository)
    {
        $this->middleware('CheckPermission:usergroup');
        $this->usergroup = $usergroupRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.usergroup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usergroup.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UsergroupRequest $request)
    {
       
        $attr = $request->all();
        $this->usergroup->createUsergroup($attr);
        return redirect('admin/usergroup');
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
        $usergroup = $this->usergroup->find($id,['id','name','desc'])->toArray();
        return view('admin.usergroup.edit',compact('usergroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UsergroupRequest $request, $id)
    {
        $res = $this->usergroup->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/usergroup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->usergroup->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/usergroup');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->usergroup->ajaxIndex($request);
        
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

}
