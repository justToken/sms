<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title></title>
    <link href="{{ asset('static/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('static/css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/css/chat.css') }}">
</head>
<body>
<header id="chat-header">
    <h2>1010</h2>
</header>
<div style="overflow: hidden;  height: 92%;">
<ul id="chat-list">
    
    <!--<li class="chat chat-type-tips">-->
        <!--<span>系统消息: FUCK进入房间</span>-->
    <!--</li>-->
    <!--<li class="chat chat-type-system">-->
        <!--<span>10:21</span>-->
    <!--</li>-->

</ul>
</div>
<footer id="chat-footer">
    <div class="chat-input">
        <textarea id="message" class="message" type="text"></textarea>
        <button class="btn n" type="button">发送</button>
    </div>
</footer>
<script src="{{ asset('static/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('static/js/chat.js') }}"></script>
<script type="text/javascript">
        $(function(){
            //check login
            doLogin();

            $(".btn").click(function(){
                sendMessage();
            })

        });

        function doLogin(){
            var name = "{{$tel}}";
            //获取头像
            var avar = parseInt(Math.random() * 10);
            if( avar == 0 ) avar = 1;
            avar = 'a' + avar + '.jpg';

            // 创建一个Socket实例
            ws = new WebSocket('ws://119.29.175.119:8090');
            ws.onopen = function(){
                console.log("握手成功");
                var msg = '{"type" : "1", "user" : "' + name + '"'+ '}';
                ws.send( msg );

            };

            ws.onmessage = function(e){
                var data = $.parseJSON( e.data );
                console.log(data);

                if( data.type == 2 ){
                    tellOnline( data.user );
                }
                if( data.type == 3 ){
                    var message = parseMessage( data.user, data.stime, data.avar, data.msg,data.class_name );
                    $("#chat-list").append( message );
                    var ex = document.getElementById("chat-list");
                    ex.scrollTop = ex.scrollHeight;
                }
                if( data.type == 6 ){
                    tellOutline( data.user );
                }

            };

            ws.onerror = function(){

                layer.close( loading );
                layer.msg( "登录失败", {'time' : 1000});
            };
        }

        //发送消息
        function sendMessage(){

            //format date
            Date.prototype.format =function(format)
            {
                var o = {
                    "M+" : this.getMonth()+1, //month
                    "d+" : this.getDate(), //day
                    "h+" : this.getHours(), //hour
                    "m+" : this.getMinutes(), //minute
                    "s+" : this.getSeconds(), //second
                    "q+" : Math.floor((this.getMonth()+3)/3), //quarter
                    "S" : this.getMilliseconds() //millisecond
                }
                if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
                        (this.getFullYear()+"").substr(4- RegExp.$1.length));
                for(var k in o)if(new RegExp("("+ k +")").test(format))
                    format = format.replace(RegExp.$1,
                            RegExp.$1.length==1? o[k] :
                                    ("00"+ o[k]).substr((""+ o[k]).length));
                return format;
            }

            var times = new Date().format("yyyy-MM-dd hh:mm:ss");

            var userinfo = "{{$tel}}";
            //socket send
            var msg = '{"type" : "3", "user" : "' + userinfo + '"'  + ', "stime" : "'
                        + times + '", "msg": "' + $("#message").val() + '"}';
            console.log(msg);
            ws.send( msg );
            var message = parseMessage( userinfo, times, "", $("#message").val(),"chat-me" );
            $("#chat-list").append( message );
            $("#message").val('');
                //滚动条自动定位到最底端
            var ex = document.getElementById("chat-list");
            ex.scrollTop = ex.scrollHeight;
        }

        function parseMessage( user, time, avar, message,class_name ){

            var _html = '<li class="chat chat-type-message '+class_name+'">'+
                           // '<img class="chat-img" src="static/img/' + avar + '" alt="">'+
                           //  '<div class="chat-info">'+
                           //      '<span class="chat-name">'+user+'</span>'+
                           //  '</div>'+
                            '<p class="chat-message">'+message+'</p>'+
                        '</li>';
            return _html;
        }


</script>
</body>
</html>