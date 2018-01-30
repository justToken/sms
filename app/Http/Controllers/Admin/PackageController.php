<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\PackageRepositoryEloquent as PackageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use DB;

class PackageController extends Controller
{
    private $package;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->middleware('CheckPermission:package');
        $this->package = $packageRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.package.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usergroup = DB::table('usergroup')->get();
        return view('admin.package.create',compact('usergroup'));
    }

    /**
     * Store a newly created resource in storage.
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(packageRequest $request)
    {
       
        $attr = $request->all();
        $attr['jgbm'] = auth('admin')->user()->id;
        $this->package->createPackage($attr);
        return redirect('admin/package');
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
        $package = $this->package->find($id,['id',"tcdm","jgbm","tcmc","jfdy","sffs","byyz","jfts","mfdw","mfsj","status"])->toArray();
        $usergroup = DB::table('usergroup')->get();
        return view('admin.package.edit',compact('package','usergroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param MenuRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(packageRequest $request, $id)
    {
        $res = $this->package->update($request->all(),$id);
        if ($res){
            flash('保存成功','success');
        }else{
            flash('保存失败','error');
        }
        return redirect('admin/package');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->package->delete($id);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/package');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->package->ajaxIndex($request);
        
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }

}
