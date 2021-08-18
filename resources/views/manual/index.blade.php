@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>マニュアル</h3>
    <hr>
    <a href="{{ route('manual.slip') }}" class="link">1.仕訳入力</a><br>
    <a href="{{ route('manual.m_slip') }}" class="link">2.月次仕訳</a><br>
    @can('admin-higher')
      <!-- 管理者権限のみ表示 -->
      <a href="{{ route('manual.y_slip') }}" class="link">3.年次決算</a><br>
      <a class="link">4.科目管理</a><br>
      <a class="link">5.ユーザー管理</a>
    @endcan
  </div>
@endsection