
@extends('layout.index')
@section('content')
<header class="header b-b b-light">
  <p>物品管理列表</p>
</header>
<section class="panel panel-default">
  <div class="row text-sm wrapper">
      <div class="col-sm-4 m-b-sx">
          <button class="btn btn-sm btn-default detailShow operate"
            data-toggle="modal" data-target="#addGood" onclick="addGood();">添加物品</button>
      </div>
    <!-- <div class="col-sm-4 m-b-xs">
      <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-sm btn-default active">
          <input type="radio" name="options" id="option1">
          Day </label>
        <label class="btn btn-sm btn-default">
          <input type="radio" name="options" id="option2">
          Week </label>
        <label class="btn btn-sm btn-default">
          <input type="radio" name="options" id="option2">
          Month </label>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="text" class="input-sm form-control" placeholder="Search">
        <span class="input-group-btn">
        <button class="btn btn-sm btn-default" type="button">Go!</button>
        </span> </div>
    </div> -->
  </div>
  <div class="table-responsive">
    <table class="table table-striped b-t b-light text-sm">
      <thead>
        <tr>
            <th style="width: 45px">略缩图</th>
            <th class="th-sortable" data-toggle="class">物品名称 <span class="th-sort"> <i class="fa fa-sort-down text"></i> <i class="fa fa-sort-up text-active"></i> <i class="fa fa-sort"></i> </span> </th>
            <th>剩余数量</th>
            <th>当前状态</th>
            <th>所需能量</th>
            <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td><img src="http://wenda.golaravel.com/uploads/avatar/000/00/54/17_avatar_max.jpg" width="40" height="40"></td>
            <td>Idrawfast</td>
            <td>70</td>
            <td>70</td>
            <td>
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-sm btn-danger active">
                  <input type="radio" name="options" id="option1">
                  <i class="fa fa-check text-active"></i> OFF </label>
                <label class="btn btn-sm btn-success">
                  <input type="radio" name="options" id="option2">
                  <i class="fa fa-check text-active"></i> NO </label>
              </div>
            </td>

            <td>
                <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#showdetails">详情</a>
                <a href="#" class="btn btn-sm btn-warning" >修改</a>
                <a href="#" class="btn btn-sm btn-danger">删除</a>
            </td>
        </tr>
        @foreach ($data as $list)
            <tr class="G{{$list->code}}">
                <td><img src="{{$list->img}}" width="40" height="40"></td>

              <td>{{$list->name}}</td>
              <td>{{$list->name}}</td>
              <td>{{$list->power}}</td>
              <td>
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-sm  btn-danger @if ($list->status_good == 0) active @endif">
                      <input type="radio" name="options" id="option1">
                      <i class="fa fa-check text-active"></i> OFF </label>
                    <label class="btn btn-sm btn-success @if ($list->status_good == 1) active @endif">
                      <input type="radio" name="options" id="option2">
                      <i class="fa fa-check text-active"></i> ON </label>
                  </div>
              </td>
              <td>
                  <a class="btn btn-sm btn-default" data-toggle="modal" data-target="#showdetails" onclick="goodDetail('{{$list->code}}')">详情</a>
                  <a class="btn btn-sm btn-warning" onclick="goodUpdate('{{$list->code}}')" data-toggle="modal" data-target="#addGood">修改</a>
                  <a class="btn btn-sm btn-danger" onclick="goodDel('{{$list->code}}')">删除</a>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <footer class="panel-footer">
    <div class="row">
      <div class="col-sm-4 hidden-xs">

      </div>
      <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> </div>
      <div class="col-sm-4 text-right text-center-xs">
          {{ $data->links() }}
      </div>
    </div>
  </footer>

<!-- 显示弹框 -->
 <div class="modal fade" id="addGood" tabindex="-1" role="dialog" aria-labelledby="mypayDetils">
     <div class="modal-dialog" role="document">
          <div class="modal-content">
              <!-- <form id="goods" onsubmit="subgood();" action="/good/add" method="post"> -->
                <header class="panel-heading font-bold">物品添加</header>
                <div class="panel-body">
                    <div class="form-group">
                      <label>物品名称</label>
                      <input type="text" class="form-control" name="good_name" id="good_name" placeholder="">
                    </div>
                    <div class="form-group">
                      <label>数量</label>
                      <input type="number" class="form-control" name="good_num" id="good_num" placeholder="">
                    </div>
                    <div class="form-group">
                      <label>所需能量</label>
                      <input type="number" class="form-control" name="good_power" id="good_power" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>图片上传</label>
                        <div >
                          <div class="bootstrap-filestyle" style="display: inline;">
                              <input type="file" data-icon="false"
                               name="good_img" id="good_img" class="form-control inline">
                               <!-- <input type="text" class="form-control inline input-s" disabled=""> -->
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>物品描述</label>
                      <input type="text" class="form-control" name="good_remark" id="good_remark" placeholder="">
                    </div>
                    <div class="alert alert-danger" style="display:none">
                    </div>
                    <div class="alert alert-success" style="display:none">
                    </div>
                    <input type="hidden"  id="substatus" value="">
                </div>
                <footer class="panel-footer text-right bg-light lter">
                      <button  onclick="subgood()" class="btn btn-success">提交</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </footer>
            <!-- </form> -->
          </div>
     </div>
  </div>
<!-- 显示弹框 -->

<!-- 显示弹框 -->
 <div class="modal fade" id="showdetails" tabindex="-1" role="dialog" aria-labelledby="mypayDetils">
     <div class="modal-dialog" role="document">
         <section class="panel panel-default">
              <header class="panel-heading">物品详情</header>
              <table class="table table-striped m-b-none text-sm">
                    <tbody>
                        <tr>
                          <td>略缩图</td>
                          <td class="text-warning">
                              <img id="detail_img" src="http://wenda.golaravel.com/uploads/avatar/000/00/54/17_avatar_max.jpg" width="40" height="40">
                          </td>
                        </tr>
                        <tr>
                            <td>物品名称</td>
                            <td class="text-success" id="detail_name">xxx</td>
                        </tr>
                        <tr>
                            <td>添加日期</td>
                            <td class="text-success" id="detail_addtime">2018-01-20</td>
                        </tr>
                        <tr>
                            <td>所需能量</td>
                            <td class="text-success" id="detail_power">70</td>
                        </tr>
                        <tr>
                            <td>物品数目</td>
                            <td class="text-warning" id="detail_num">70</td>
                        </tr>
                        <tr>
                            <td>剩余数目</td>
                            <td class="text-warning" id="detail_last_num">65</td>
                        </tr>
                        <tr>
                            <td>状态</td>
                            <td class="text-danger" id="detail_status">继续发放</td>
                        </tr>
                    </tbody>
              </table>
              <footer class="panel-footer text-right bg-light lter">
              </footer>
        </section>

     </div>

  </div>
<!-- 显示弹框 -->
</section>
<!-- / footer --> <script src="{{ asset('js/app.js') }}"></script><!-- Bootstrap --> <!-- App -->

<script type="text/javascript">
function dangershow(msg) {
    $('.alert-danger').show()
    $('.alert-danger').append(msg)
    setInterval(dangerhide, 2000)
}
function dangerhide() {
    $('.alert-danger').hide()
    $('.alert-danger').text("")
}
function successshow(msg) {
    $('.alert-success').show()
    $('.alert-success').append(msg)
    setInterval(successhide, 2000)
}
function successhide() {
    $('.alert-success').hide()
    $('.alert-success').text("")
}
function subgood() {
    let good_name = $('#good_name').val()
    let good_num = $('#good_num').val()
    let good_img = $('#good_img').get(0).files[0]
    let good_power = $('#good_power').val()
    let good_remark = $('#good_remark').val()
    if (!good_name) {
        dangershow('物品名不得为空')
    } else if (!good_num) {
        dangershow('数量不得为空')
    } else if (!good_power) {
        dangershow('所需能量不得为空')
    } else if (!good_img) {
        dangershow('图片不得为空')
    } else if (!good_remark) {
        dangershow('商品描述不得为空')
    } else {
        let formData = new FormData()
        formData.append('good_name', good_name)
        formData.append('good_power', good_power)
        formData.append('good_num', good_num)
        formData.append('good_remark', good_remark)
        formData.append('good_img', good_img)
        formData.append('substatus', $('#substatus').val())
        console.log(formData);
        $.ajax({
           url: "/good/add",
           type: 'POST',
           data: formData,
           contentType: false,
           processData: false,
           success: function (res) {
               let rest = res.original
               if (rest.code == 1) {
                   // successshow(rest.msg)
                   window.location.reload()
               } else {
                   dangershow(rest.msg)
               }
           },
           error: function (res) {
           }
          });
    }
}
// 详情
function goodDetail(code) {
    $.get('/good/get/'+code, function(res) {
        let rest = res
        let detail_status = rest.status_good
        let status_msg = ''
        if (detail_status == 1) {
            status_msg = '继续发放'
        } else {
            status_msg = '暂停发放'
        }
        $('#detail_img').attr('src',rest.img)
        $('#detail_name').text(rest.name)
        $('#detail_last_num').text(rest.last_num)
        $('#detail_addtime').text(rest.time)
        $('#detail_power').text(rest.power)
        $('#detail_status').text(status_msg)

    })
}
// 更新
function goodUpdate(code) {
    $.get('/good/get/'+code, function(res) {
        $('#substatus').val(code)
        console.log($('#substatus').val());
        $('#good_name').val(res.name)
        $('#good_num').val(res.num)
        $('#good_power').val(res.power)
        $('#good_remark').val(res.remark)

        // let good_name = $('#good_name').val()
        // let good_num = $('#good_num').val()
        // let good_img = $('#good_img').get(0).files[0]
        // let good_power = $('#good_power').val()
        // let good_remark = $('#good_remark').val()
    })
}
// 删除
function goodDel(code) {
    let result = confirm('是否删除！');
    if(result){
        $.get('/good/del/'+code, function(res) {
            if (res.original.code == 1) {
                $('.G'+code).hide()
            }
        })
    }

}

// 清除数据
function addGood() {
    $('#good_name').val("")
    $('#good_num').val("")
    $('#good_power').val("")
    $('#good_remark').val("")
    var obj = document.getElementById('good_img') ;
    obj.outerHTML=obj.outerHTML;
    $('#substatus').val('1')
    console.log($('#substatus').val());
}
</script>
@endsection
