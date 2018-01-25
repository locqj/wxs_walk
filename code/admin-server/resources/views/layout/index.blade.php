<!DOCTYPE html>
<html lang="en" class="app">
<head>
<meta charset="utf-8" />
<title>步数换物管理后台</title>
<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="{{ asset('css/app.v2.css') }}" rel="stylesheet">
<link href="{{ asset('js/prettyphoto/prettyPhoto.css') }}" rel="stylesheet">
<link href="{{ asset('js/grid/gallery.css') }}" rel="stylesheet">

<!--[if lt IE 9]> <script src="js/ie/html5shiv.js" cache="false"></script> <script src="js/ie/respond.min.js" cache="false"></script> <script src="js/ie/excanvas.js" cache="false"></script> <![endif]-->
</head>
<body>
<section class="vbox">
  <header class="bg-black dk header navbar navbar-fixed-top-xs">
    <div class="navbar-header aside-md">
         <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="images/logo.png" class="m-r-sm">步数换物管理后台</a> <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a> </div>
    <ul class="nav navbar-nav navbar-left hidden-xs nav-user">
        <li class="dropdown" >
            <a href="#" class="btn"  data-toggle="modal" data-target="#setpassword">修改密码</a>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right hidden-xs nav-user">
        <li class="dropdown">
            <a href="" class="dropdown-toggle dker"data-toggle="ajaxModal" >欢迎 {{ Session::get('username') }}</a>
        </li>
        <li class="dropdown">
          <a href="" class="dropdown-toggle dker" data-toggle="ajaxModal" >退出</a>
        </li>
    </ul>
  </header>
  <section>
    <section class="hbox stretch"> <!-- .aside -->
      <aside class="bg-black lter aside-md hidden-print" id="nav">
        <section class="vbox">
          <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333"> <!-- nav -->
              <nav class="nav-primary hidden-xs">
                <ul class="nav">
                    <li class="@if($_SERVER['REQUEST_URI'] == '/index') active @endif">
                        <a href="/index">
                            <i class="fa fa-file-text icon">
                                <b class="bg-primary"></b>
                            </i>
                            <span>首页</span>
                        </a>
                    </li>
                  <li class="@if($_SERVER['REQUEST_URI'] == '/goods') active @endif">
                      <a href="/goods">
                          <i class="fa fa-dashboard icon">
                              <b class="bg-danger"></b>
                          </i>
                          <span>物品管理</span>
                      </a>
                  </li>

                  <li class="@if($_SERVER['REQUEST_URI'] == '/check') active @endif">
                      <a href="/check" >
                          <i class="fa fa-envelope-o icon"> <b class="bg-primary dker"></b> </i>
                          <span>核销统计</span>
                      </a>
                  </li>
                  <li class="@if($_SERVER['REQUEST_URI'] == '/info') active @endif">
                      <a href="/info" >
                          <i class="fa fa-pencil icon"> <b class="bg-info"></b> </i>
                          <span>系统说明</span>
                      </a>
                  </li>

                </ul>
              </nav>
              <!-- / nav --> </div>
          </section>
          <footer class="footer lt hidden-xs b-t b-light">
            <div id="chat" class="dropup">
              <section class="dropdown-menu on aside-md m-l-n">
                <section class="panel bg-white">
                  <header class="panel-heading b-b b-light">Active chats</header>
                  <div class="panel-body animated fadeInRight">
                    <p class="text-sm">No active chats.</p>
                    <p><a href="#" class="btn btn-sm btn-default">Start a chat</a></p>
                  </div>
                </section>
              </section>
            </div>
            <div id="invite" class="dropup">
              <section class="dropdown-menu on aside-md m-l-n">
                <section class="panel bg-white">
                  <header class="panel-heading b-b b-light"> John <i class="fa fa-circle text-success"></i> </header>
                  <div class="panel-body animated fadeInRight">
                    <p class="text-sm">No contacts in your lists.</p>
                    <p><a href="#" class="btn btn-sm btn-facebook"><i class="fa fa-fw fa-facebook"></i> Invite from Facebook</a></p>
                  </div>
                </section>
              </section>
            </div>
          </footer>
        </section>
      </aside>
      <!-- /.aside -->
      <section id="content">
        <section class="vbox bg-white">

          <!-- 内容区 -->
          @yield('content')
          <!-- 内容区 -->
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
      <aside class="bg-light lter b-l aside-md hide" id="notes">
        <div class="wrapper">Notification</div>
      </aside>
    </section>
  </section>
</section>
<!-- 显示弹框 -->
 <div class="modal fade" id="setpassword" tabindex="-1" role="dialog" aria-labelledby="mypayDetils">
     <div class="modal-dialog" role="document">
          <div class="modal-content">
                <header class="panel-heading font-bold">修改密码</header>
                <div class="panel-body">
                    <div class="form-group">
                      <label>旧密码</label>
                      <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                      <label>新密码</label>
                      <input type="number" class="form-control" placeholder="">
                    </div>

                </div>
                <footer class="panel-footer text-right bg-light lter">
                      <button type="submit" class="btn btn-success">提交</button>
                      <button type="submit" class="btn btn-danger" data-dismiss="modal">取消</button>
                </footer>
          </div>

     </div>
  </div>
<!-- 显示弹框 -->
<!-- / footer -->
<script src="{{ asset('js/app.js') }}"></script>


</body>
</html>
