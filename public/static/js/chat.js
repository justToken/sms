$(function() {
    function unfolded(rsize) {
        $('#chat-list').css('height', rsize.lo);
        $('#chat-footer').css('height', rsize.fo);
    }
    function resize() {
        var s768 = {lo: '85%', fo: '10%', le: '61%', fe: '34%'};
        var s768lt = {lo: '83%', fo: '11%', le: '46%', fe: '48%'};
        var s375lt = {lo: '92%', fo: '8%', le: '36%', fe: '56%'};

        if($(window).width() >= 768) {
            unfolded(s768);
        }else if($(window).width() < 375) {
            unfolded(s375lt);
        }else if($(window).width() < 768) {
            unfolded(s768lt);
        }
    }

    function selfMessage(id) {
        if (user.id == parseInt(id)) {
            return 'chat-me';
        }
        return 'chat-ta';
    }




    if($(window).width() < 375) {
        $('#chat-list').css('height', '92%');
        $('#chat-footer').css('height','8%');
    }else if($(window).width() < 768) {
        $('#chat-list').css('height', '96%');
        $('#chat-footer').css('height','4%');
    }

    $(window).resize(function() {
        resize()
    })

    var text;
    $('.message').bind('input propertychange', function() {
        var message = $('.message');
        var val = message.val();
        console.log(val.length);

        (message.val().length > 0) ? $('.btn').attr('class', 'btn y'):$('.btn').attr('class', 'btn n');

        if (message.val().length >= 130) {
            message.val(text);
            alert('输入文字过长');
            return;
        }

        text = val;
    })

    $('.message').focus(function () {
        var message = $('.chat-input>.message');
        var text = message.val();
        message.val(text);

        var btn = $('.btn');
        if(message.val().length > 0) {
            btn.attr('class', 'btn y')
        }else {
            btn.attr('class', 'btn n');
        }
    })

})