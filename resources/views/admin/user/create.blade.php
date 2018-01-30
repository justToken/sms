@extends('admin.layouts.admin')

@section('admin-css')
    <link href="{{ asset('asset_admin/assets/plugins/parsley/src/parsley.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen"/>
@endsection

@section('admin-content')
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">新增用户</h1>
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
                        <h4 class="panel-title">后台用户列表</h4>
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
                        <form class="form-horizontal form-bordered" data-parsley-validate="true" action="{{ url('admin/user') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="sjhm">手机号码 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="sjhm" placeholder="手机号码" data-parsley-required="true" data-parsley-required-message="请输入手机号码" value="{{ old('sjhm') }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="yhxm">用户姓名 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="yhxm" placeholder="用户姓名" data-parsley-length="[2,20]" data-parsley-length-message="姓名长度2~20字符" data-parsley-required="true" data-parsley-required-message="请输入姓名" value="{{ old('yhxm') }}"/>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="khh">银行账户 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="khh" placeholder="银行账户" data-parsley-required="true" data-parsley-required-message="请输入银行账户" value="{{ old('khh') }}"/>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">证件类型 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#zjlx_error"
                                            data-parsley-required-message="请选择证件类型"
                                            name="zjlx">
                                        <option value="">-- 请选择 --</option>
                                        <!-- <option value="0">其他</option> -->
                                        <option value="0">身份证</option>
                                        <option value="1">居住证</option>
                                        <option value="2">护照</option>
                                        <option value="3">户口本</option>
                                        <option value="4">军人证</option>
                                    </select>
                                    <p id="zjlx_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="zjhm">证件号码 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" id="zjhm" type="text" name="zjhm" placeholder="证件号码" data-parsley-length="[6,20]" data-parsley-length-message="证件号码长度6~20字符" data-parsley-required="true" data-parsley-required-message="请输入证件号码" value="{{ old('zjhm') }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="icon">所属分组 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control selectpicker"
                                            data-live-search="true"
                                            data-style="btn-white"
                                            data-parsley-required="true"
                                            data-parsley-errors-container="#usergroup_error"
                                            data-parsley-required-message="请选择所属分组"
                                            name="usergroup">
                                          <option value="">-- 请选择 --</option>
                                            @foreach($usergroup as $group)
                                            <option value="{{ $group->id }}"  @if($group->name == '普通组') selected="selected" @endif>{{ $group->name }}</option>
                                            @endforeach
                                    </select>
                                    <p id="usergroup_error"></p>
                                </div>
                            </div>
                           <!--  <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="gddh">联系电话 * :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" id="gddh" type="text" name="gddh" placeholder="联系电话" data-parsley-length="[7,20]" data-parsley-length-message="联系电话长度7~20字符" data-parsley-required="true" data-parsley-required-message="请输入联系电话" value="{{ old('zjhm') }}"/>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="qssj">起始时间 * :</label>
                                <div class="input-group date form_date col-md-6 col-sm-6" data-date="" data-date-format="yyyy-mm-dd" data-link-field="qssj" data-link-format="yyyy-mm-dd" >
                                    <input class="form-control" size="16" type="text" value="{{ date('Y-m-d') }}" data-parsley-required="true"
                                    data-parsley-errors-container="#qssj_error"
                                    data-parsley-required-message="请选起始时间" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <p id="qssj_error"></p>
                                <input type="hidden" id="qssj" name="qssj"  value="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="zzsj">终止时间 * :</label>
                                <div class="input-group date form_date col-md-6 col-sm-6" data-date="" data-date-format="yyyy-mm-dd" data-link-field="zzsj" data-link-format="yyyy-mm-dd" >
                                    <input  id="zzsj" class="form-control" size="16" type="text" value="{{ date('Y-m-d',strtotime('+1 month')) }}" 
                                    data-parsley-required="true"
                                    data-parsley-required-message="请选择终止时间" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                   
                                </div>
                                <input type="hidden" id="zzsj" name="zzsj"  value="{{ date('Y-m-d',strtotime('+1 month')) }}" />
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="dzyx">电子邮箱  :</label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" id="dzyx" type="text" name="dzyx" placeholder="电子邮箱" data-parsley-length="[7,20]" data-parsley-length-message="联系电话长度7~20字符" data-parsley-required="false" data-parsley-required-message="请输入联系电话" value="{{ old('dzyx') }}"/>
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
    <script src="{{ asset('asset_admin/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('asset_admin/assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script>
        $('.selectpicker').selectpicker('render');
        $('.form_date').datetimepicker({
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            defaultDate:true
        });
    </script>
@endsection