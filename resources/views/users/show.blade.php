@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
      <div class="card ">
        <img class="card-img-top"
          src="{{ $user->getavcatar() }}"
          alt="{{ $user->name }}">
        <div class="card-body">
          <h5><strong>个人简介</strong></h5>
          <p>专业躺平二十年，曾靠嘴炮搞定无数需求。代码能跑就行，bug 多如牛毛。左手 Ctrl+C，右手 Ctrl+V，键盘上跳舞的艺术家。产品经理见了会沉默，测试工程师见了会流泪。 </p>
          <hr>
          <h5><strong>注册于</strong></h5>
          <p>{{ $user->created_at->diffForHumans() }}</p>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="card ">
        <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
        </div>
      </div>
      <hr>

      {{-- 用户发布的内容 --}}
      <div class="card ">
        <div class="card-body">
          暂无数据 ~_~
        </div>
      </div>

    </div>
  </div>
@stop