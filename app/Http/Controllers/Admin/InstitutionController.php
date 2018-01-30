<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\InstitutionRepositoryEloquent as InstitutionRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstitutionRequest;

class InstitutionController extends Controller
{
    private $institution;

    public function __construct(InstitutionRepository $institutionRepository)
    {
        $this->middleware('CheckPermission:institution');
        $this->institution = $institutionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.institution.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.institution.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(InstitutionRequest $request)
    {
        $this->institution->createInstitution($request->all());
        return redirect('admin/institution');
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
        $institution = $this->institution->find($id,['id','jgmc','tel','address'])->toArray();
        return view('admin.institution.edit',compact('institution'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(InstitutionRequest $request, $id)
    {
        $res = $this->institution->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/institution');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->institution->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/institution');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->institution->ajaxIndex($request);
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

    public function serviceNetwork(Request $request){
        $institution = $this->institution->getAll();
        return view('admin.institution.servicenetwork',compact('institution'));
    }
}
