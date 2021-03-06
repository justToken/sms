@extends('admin.layouts.admin')

@section('admin-css')
    <link href="{{ asset('asset_admin/assets/plugins/parsley/src/parsley.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
@endsection

@section('admin-content')
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">修改菜单</h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">菜单列表</h4>
                    </div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body panel-form">
                        <form class="form-horizontal form-bordered" data-parsley-validate="true" action="{{ url('admin/menus/'.$menu['id']) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="name">菜单名称 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="name" placeholder="菜单名称" data-parsley-required="true" data-parsley-required-message="请输入菜单名称" value="{{ $menu['name'] }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="url">菜单链接 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="url" placeholder="菜单链接" data-parsley-required="true" data-parsley-required-message="请输入菜单链接" value="{{ $menu['url'] }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="slug">权限名称 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="slug" placeholder="权限名称" data-parsley-required="true" data-parsley-required-message="请输入权限名称" value="{{ $menu['slug'] }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">菜单图标 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="icon" placeholder="菜单图标" value="{{ $menu['icon'] }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">上级菜单 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#parent_id_error"
                                            data-parsley-required-message="请选择上级菜单"
                                            name="parent_id">
                                        <option value="">-- 请选择 --</option>
                                        <option value="0" @if($menu['parent_id'] == 0) selected="selected" @endif>顶级菜单</option>
                                        @foreach($topMenus as $value)
                                        <option value="{{ $value->id }}" @if($value->id == $menu['parent_id']) selected="selected" @endif>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="parent_id_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4"></label>
                                <div class="col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('asset_admin/assets/plugins/parsley/dist/parsley.js') }}"></script>
    <script src="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script>
        $('.selectpicker').selectpicker('render');
    </script>
@endsection