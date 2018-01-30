@extends('admin.layouts.admin')

@section('admin-css')
    <link href="{{ asset('asset_admin/assets/plugins/parsley/src/parsley.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
@endsection

@section('admin-content')
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <!--<ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li><a href="javascript:;">Form Stuff</a></li>
            <li class="active">Form Validation</li>
        </ol>-->
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">修改套餐</h1>
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
                        <h4 class="panel-title">套餐列表</h4>
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
                        <form class="form-horizontal form-bordered" data-parsley-validate="true" action="{{ url('admin/package/'.$package['id']) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="tcmc">套餐名称 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="tcmc" placeholder="套餐名称" data-parsley-required="true" data-parsley-required-message="请输入套餐名称" value="{{ $package['tcmc'] }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="byyz">包月月租 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="byyz" placeholder="包月月租" data-parsley-required="true" data-parsley-required-message="请输入包月月租" value="{{ $package['byyz'] }}"/>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">计费定义 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#jfdy_error"
                                            data-parsley-required-message="请选择计费定义"
                                            name="jfdy">
                                        <option value="">-- 请选择 --</option>
                                        <!-- <option value="0">其他</option> -->
                                        <option value="0" @if($package['jfdy'] == 0) selected="selected" @endif >按套餐</option>
                                        <option value="1" @if($package['jfdy'] == 1) selected="selected" @endif>按短信类型</option>
                                        <option value="2" @if($package['jfdy'] == 2) selected="selected" @endif>按套餐+短信类型</option>
                                    </select>
                                    <p id="jfdy_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">收费方式 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#sffs_error"
                                            data-parsley-required-message="请选择收费方式"
                                            name="sffs">
                                        <option value="">-- 请选择 --</option>
                                        <!-- <option value="0">其他</option> -->
                                        <option value="0" @if($package['sffs'] == 0) selected="selected" @endif>免费</option>
                                        <option value="1" @if($package['sffs'] == 1) selected="selected" @endif>包月</option>
                                        <option value="2" @if($package['sffs'] == 2) selected="selected" @endif>按条数</option>
                                        <option value="3" @if($package['sffs'] == 3) selected="selected" @endif>包月封顶</option>
                                        <option value="4" @if($package['sffs'] == 4) selected="selected" @endif>按条封顶</option>
                                    </select>
                                    <p id="sffs_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">计费方式 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#jfts_error"
                                            data-parsley-required-message="请选择计费方式"
                                            name="jfts">
                                        <option value="">-- 请选择 --</option>
                                        <!-- <option value="0">其他</option> -->
                                        <option value="0" @if($package['jfts'] == 0) selected="selected" @endif>下行</option>
                                        <option value="1" @if($package['jfts'] == 1) selected="selected" @endif>上行</option>
                                        <option value="2" @if($package['jfts'] == 2) selected="selected" @endif>下行-上行</option>
                                        <option value="3" @if($package['jfts'] == 3) selected="selected" @endif>下行+上行</option>
                                    </select>
                                    <p id="jfts_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="mfsj">免费时间 :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="mfsj" placeholder="免费时间" data-parsley-required="false" data-parsley-required-message="请输入免费时间" value="{{ $package['mfsj']}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">免费单位  :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="false"
                                            data-parsley-errors-container="#mfdw_error"
                                            data-parsley-required-message="请选择免费单位"
                                            name="mfdw">
                                        <option value="">-- 请选择 --</option>
                                        <!-- <option value="0">其他</option> -->
                                        <option value="0" @if($package['mfdw'] == 0) selected="selected" @endif>天</option>
                                        <option value="1" @if($package['mfdw'] == 1) selected="selected" @endif>月</option>
                                        <option value="2" @if($package['mfdw'] == 2) selected="selected" @endif>年</option>
                                    </select>
                                    <p id="mfdw_error"></p>
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
@endsection