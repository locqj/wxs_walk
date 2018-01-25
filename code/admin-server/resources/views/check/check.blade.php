@extends('layout.index')
@section('content')
<header class="header b-b b-light">
  <p>物品核销管理列表</p>
</header>
<section class="panel panel-default">
  <div class="row text-sm wrapper">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control input-s-sm inline" id="goodlist" >
          <option value="0">全部</option>
          @foreach ($good_lists as $list)
              <option value={{$list->code}}>{{$list->name}}</option>
          @endforeach
        </select>
        <button class="btn btn-sm btn-default" onclick="selectGoods();">查询</button>
      </div>
    <div class="col-sm-4 m-b-xs">
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
  </div>
  <div class="table-responsive">
    <table class="table table-striped b-t b-light text-sm">
      <thead>
        <tr>
            <th style="width: 45px">头像</th>
            <th class="th-sortable" data-toggle="class">昵称 <span class="th-sort"> <i class="fa fa-sort-down text"></i> <i class="fa fa-sort-up text-active"></i> <i class="fa fa-sort"></i> </span> </th>
            <th>核销商品</th>
            <th>兑换日期</th>
            <th>核销日期</th>
            <th>当前状态</th>
        </tr>
      </thead>
      <tbody>
        @foreach($check_list as $list)
        <tr>
            <td><img src="{{$list->head_img}}" width="40" height="40"></td>
            <td>{{$list->nickname}}</td>
            <td>{{$list->good->name}}</td>
            <td>Jul 25, 2013</td>
            <td>Jul 25, 2013</td>
            <td>@if ($list->status_check == 1)已核销 @else 未核销 @endif</td>
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
        <!-- pages分页 -->
      </div>
    </div>
  </footer>

</section>
<!-- / footer --> <script src="{{ asset('js/app.js') }}"></script><!-- Bootstrap --> <!-- App -->

<script type="text/javascript">
    let paramCode = getQueryString('good_code')
    if (paramCode != null) {
        $("#goodlist").find("option[value='"+paramCode+"']").attr("selected",true)
    }
    function getQueryString(name) {
        let reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
        let r = window.location.search.substr(1).match(reg);
        if (r != null) {
            return unescape(r[2]);
        }
            return null;
    }
    function selectGoods() {
        let good = $('#goodlist').val()
        if (good == 0) {
            window.location.href = '/check'
        } else {
            window.location.href = '/check?good_code='+good
        }
    }
</script>
@endsection
