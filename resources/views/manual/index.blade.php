@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>マニュアル</h3>
    <hr>
    <h5>1.仕訳入力</h5>
    <h5>2.月次仕訳</h5>
    @can('admin-higher')
      <!-- 管理者権限のみ表示 -->
      <h5>3.年次決算</h5>
      <h5>4.科目管理</h5>
      <h5>5.ユーザー管理</h5>
    @endcan
  </div>
@endsection