<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
<meta charset="utf-8" />
<title>步数换沙拉</title>
<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="{{ asset('css/app.v2.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('fonts/font.css') }}" rel="stylesheet"> -->

<!--[if lt IE 9]> <script src="js/ie/html5shiv.js" cache="false"></script> <script src="js/ie/respond.min.js" cache="false"></script> <script src="js/ie/excanvas.js" cache="false"></script> <![endif]-->
</head>
<body>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown" >
  <div class="container aside-xxl"> <a class="navbar-brand block" href="/">步数换物管理后台</a>
    <section class="panel panel-default m-t-lg bg-white">
      <header class="panel-heading text-center"> <strong>注册</strong> </header>
      <div class="panel-body wrapper-lg">
        <div class="form-group" id="name-group">
          <label class="control-label">商家账号</label>
          <input type="text"  id="business_name" placeholder="" class="form-control input-lg">
        </div>
        <div class="form-group" id="pwd-group">
          <label class="control-label">密码</label>
          <input type="password"  id="pwd" placeholder="" class="form-control input-lg">
        </div>
        <div class="form-group" id="spwd-group">
          <label class="control-label">确认密码</label>
          <input type="password" id="spwd"  placeholder="" class="form-control input-lg">
        </div>
        <div class="alert alert-danger" style="display:none">
        </div>
        <div class="alert alert-success" style="display:none">
        </div>
        <a  id="sub" class="btn btn-primary btn-block">注册</a>
        <div class="line line-dashed"></div>
        <p class="text-muted text-center" id="login-box"><small>已有账号？登陆</small></p>
    </div>
    </section>
  </div>
</section>
<!-- footer -->
<footer id="footer">
  <div class="text-center padder clearfix">
    <p> <small>HZX软件开发设计团队<br>
      &copy; 2018</small> </p>
  </div>
</footer>
<!-- / footer --> <script src="{{ asset('js/app.js') }}"></script><!-- Bootstrap --> <!-- App -->
</body>
<script type="text/javascript">


$(document).ready(function() {

    function successshow(msg) {
        $('.alert-success').show()
        $('.alert-success').append(msg)
        setInterval(successhide, 2000)
    }
    function dangershow(msg) {
        $('.alert-danger').show()
        $('.alert-danger').append(msg)
        setInterval(dangerhide, 2000)
    }
    function successhide() {
        $('.alert-success').hide()
        $('.alert-success').text("")
    }
    function dangerhide() {
        $('.alert-danger').hide()
        $('.alert-danger').text("")
    }
    $('#login-box').click(function() {
        window.location.href = '/signout'
    })

    // 表单提交
    $('#sub').click(function() {
        let business_name = $('#business_name').val()
        let pwd = $('#pwd').val()
        let spwd = $('#spwd').val()
        if (!business_name) {
            dangershow('商户名不得为空')
        } else if (!pwd) {
            dangershow('密码不得为空')
        } else if (pwd != spwd) {
            dangershow('两次密码不一致')
        } else {
            $.post('/signout/register', {name: business_name, pwd: pwd}, function(res){
                let rest = res.original
                if (rest.code == 1) {
                    $('.alert-success').show()
                    $('.alert-success').append(rest.msg)
                    setInterval(window.location.href="/", 2000)
                } else {
                    dangershow(rest.msg)
                }
            })
        }

    })
    // 检验商户名
    $('#business_name').blur(function() {

        let business_name = $('#business_name').val()
        if (business_name) {
            $.post('/signout/distname', {name: business_name}, function(res){
                let rest = res.original
                if (rest.code == 1) {
                    successshow(rest.msg)
                } else {
                    dangershow(rest.msg)
                }
            })
        } else {
            dangershow("商户名不得为空")
        }
    })



});

</script>
</html>
