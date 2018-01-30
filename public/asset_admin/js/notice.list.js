$(document).ready(function () {
    var lang = {
        "sProcessing": "处理中...",
        "sLengthMenu": "每页 _MENU_ 项",
        "sZeroRecords": "没有匹配结果",
        "sInfo": "当前显示第 _START_ 至 _END_ 项，共 _TOTAL_ 项。",
        "sInfoEmpty": "当前显示第 0 至 0 项，共 0 项",
        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
        "sInfoPostFix": "",
        "sSearch": "搜索:",
        "sUrl": "",
        "sEmptyTable": "没有查到数据",
        "sLoadingRecords": "载入中...",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上页",
            "sNext": "下页",
            "sLast": "末页",
            "sJump": "跳转"
        },
        "oAria": {
            "sSortAscending": ": 以升序排列此列",
            "sSortDescending": ": 以降序排列此列"
        }};

    $('#datatable').DataTable({
        "processing": true,
        'language':lang,
        "serverSide": true,
        'searchDelay':300,//搜索延时
        'search':{
            regex : true//是否开启模糊搜索
        },
        "ajax": {
            'url' : "/admin/notice/ajaxIndex"
        },
        "createdRow": function( row, data, dataIndex ) {
            if(data.content.length > remarkShowLength){//只有超长，才有td点击事件
                $(row).children('td').eq(3).attr('onclick','javascript:changeShowRemarks(this);');
            }
            $(row).children('td').eq(3).attr('content',data.content);
        },
        "columnDefs" : [{
            "type": "date",
            "targets": 3,
            "render": function (data, type, full, meta) {
                if (full.content.length > remarkShowLength) {
                    return getPartialRemarksHtml(full.content);//显示部分信息
                } else {
                    return full.content;//显示原始全部信息           
                }
            }
        }],
        'aLengthMenu':[50,100],
        
        "columns": [
            {"data": "id","name" : "id"},
            {"data": "name","name" : "name","orderable" : false},
            {"data": "groupname","name": "groupname","orderable" : false},
            {"data": "content","name": "content","orderable" : false},
            {"data": "button","name": "button",'type':'html',"orderable" : false}
        ]
    });


});

var remarkShowLength = 20;//默认现实的字符串长度
//切换显示备注信息，显示部分或者全部
function changeShowRemarks(obj){//obj是td
   var content = $(obj).attr("content");
   if(content != null && content != ''){
      if($(obj).attr("isDetail") == 'true'){//当前显示的是详细备注，切换到显示部分
         //$(obj).removeAttr('isDetail');//remove也可以
         $(obj).attr('isDetail',false);
         $(obj).html(getPartialRemarksHtml(content));
      }else{//当前显示的是部分备注信息，切换到显示全部
         $(obj).attr('isDetail',true);
         $(obj).html(getTotalRemarksHtml(content));
      }
   }
}

//部分备注信息
function getPartialRemarksHtml(remarks){
      return remarks.substr(0,remarkShowLength) + '&nbsp;&nbsp;<a href="javascript:void(0);" ><b>...</b></a>';
}

//全部备注信息
function getTotalRemarksHtml(remarks){
      return remarks + '&nbsp;&nbsp;<a href="javascript:void(0);" >收起</a>';
}