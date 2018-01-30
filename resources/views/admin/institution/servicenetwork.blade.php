@extends('admin.layouts.admin')

@section('admin-css')
    <link href="{{ asset('asset_admin/assets/plugins/parsley/src/parsley.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
    <style>
        #container{
            height:48em;
        }
    </style>
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
        <h1 class="page-header">服务网点</h1>
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
                        <h4 class="panel-title">服务网点</h4>
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
                    <select id="selectpicker"
                            class="form-control selectpicker"
                            data-live-search="true"
                            data-style="btn-white"
                            data-parsley-required="true"
                            data-parsley-errors-container="#role_error"
                            data-parsley-required-message="请选择角色"
                            name="role">
                        <option value="">-- 请选择 --</option>
                        @foreach($institution as $key=>$value)
                            <option value="{{ $value['address'] }}">{{ $value['jgmc'] }}</option>
                        @endforeach
                    </select>

                    <div id="container" class="panel-body panel-form"></div>
                    <div id="r-result"></div>
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
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=U2BGpfGxmydEOMrXMG5AcqwUIhncfDto"></script>
    <script>
         var map = new BMap.Map("container"); // 创建地图实例
         var adds = [
            @foreach($institution as $v)
                "{{ $v['address'] }}",
            @endforeach
         ];

         var contents = [
             @foreach($institution as $v)
                "{{ $v['jgmc'] }}<br>{{ $v['address'] }}<br>{{ $v['tel'] }}",
            @endforeach
         ]
         console.log(adds);
        map.centerAndZoom(new BMap.Point(116.758,36.559),11);  // 初始化地图,设置中心点坐标和地图级别
        // //添加地图类型控件
        map.addControl(new BMap.MapTypeControl({
            mapTypes:[
                BMAP_NORMAL_MAP,
                BMAP_HYBRID_MAP
            ]
        }));	  
        // // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        var index = 0
        for(var add of adds ){
            // 将地址解析结果显示在地图上,并调整地图视野
            myGeo.getPoint(add, function(point){
                if (point) {
                    var address = new BMap.Point(point.lng, point.lat);
                    addMarker(address,index);
                    ++index;
                }else{
                    //alert("您选择地址没有解析到结果!--"+add);
                }
            }, ""); 
        }

        var opts = {
            width : 70,     // 信息窗口宽度
            height: 20,     // 信息窗口高度
            title : "" , // 信息窗口标题
            enableMessage:true//设置允许信息窗发送短息
        };

         var local = new BMap.LocalSearch(map, {
             renderOptions: {map: map, panel: "r-result"}
         });


        map.enableScrollWheelZoom(true);//开启鼠标滚轮缩放
         $('.selectpicker').selectpicker('render');
         $('#selectpicker').change(function(){
             console.log($(this).val());
             local.search($(this).val());
         });
        function addMarker(point,index){
            var marker = new BMap.Marker(point);
            map.addOverlay(marker);
            addClickHandler(contents[index],marker);
            //marker.setLabel(label);
        }
        
        function addClickHandler(content,marker){
		    marker.addEventListener("click",function(e){
			openInfo(content,e)}
		    );
	    }
	    function openInfo(content,e){
            var p = e.target;
            var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
            var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
            map.openInfoWindow(infoWindow,point); //开启信息窗口
	    }

    </script>
@endsection