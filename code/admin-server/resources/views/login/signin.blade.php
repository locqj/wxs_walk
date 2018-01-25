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
      <header class="panel-heading text-center"> <strong>登陆</strong> </header>
      <div class="panel-body wrapper-lg">
        <div class="form-group">
          <label class="control-label" >商家账号</label>
          <input type="text" id="business_name" placeholder="" class="form-control input-lg">
        </div>
        <div class="form-group">
          <label class="control-label">密码</label>
          <input type="password" id="pwd" placeholder="" class="form-control input-lg">
        </div>
        <div class="alert alert-danger" style="display:none">
        </div>
        <div class="alert alert-success" style="display:none">
        </div>
        <a  id="sub" class="btn btn-primary btn-block">登陆</a>
        <div class="line line-dashed"></div>
        <p class="text-muted text-center" id="rigister-box"><small>未有账号？注册</small></p>
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
    function dangershow(msg) {
        $('.alert-danger').show()
        $('.alert-danger').append(msg)
        setInterval(dangerhide, 2000)
    }
    function dangerhide() {
        $('.alert-danger').hide()
        $('.alert-danger').text("")
    }
    $('#rigister-box').click(function() {
        window.location.href = '/signout'
    })
    $('#sub').click(function() {
        let name = $('#business_name').val()
        let pwd = $('#pwd').val()
        if (!name) {
            dangershow("商户名不得为空")
        } else if (!pwd) {
            dangershow("密码不得为空")
        } else {
            $.post('/signin', {name: name, pwd: pwd}, function(res) {
                let rest = res.original
                if (rest.code == 1) {
                    $('.alert-success').show()
                    $('.alert-success').append(rest.msg)
                    setInterval(window.location.href="/index", 2000)
                } else {
                    dangershow(rest.msg)
                }
            })
        }
    })
})
</script>
</html>
