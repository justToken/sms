<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
</head>
<body>
  <ul class="pages">
    <li class="login page">
      <div class="form">
        <h3 class="title">你的电话是</h3>
        <input class="usernameInput" type="text" maxlength="14" />
      </div>
    </li>
  </ul>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script>
	$(function(){
	document.onkeydown = function(e){ 
    var ev = document.all ? window.event : e;
    if(ev.keyCode==13) {

          window.location.href = "room/"+$(".usernameInput").val();

     }
}
});  
</script>
</body>
</html>