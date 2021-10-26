@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>マニュアル</h3>
    <hr>
    <h5>一般</h5>
    <a href="{{ route('manual.defect') }}" class="link">1.システム不具合かなと思ったら</a><br>
    <a href="{{ route('manual.slip') }}" class="link">2.仕訳入力</a><br>
    <a href="{{ route('manual.m_slip') }}" class="link">3.月次仕訳</a><br>
    @can('admin-higher')
      <!-- 管理者権限のみ表示 -->
      <h5>管理者メニュー(管理者権限ユーザーのみ表示されます)</h5>
      <a href="{{ route('manual.y_slip') }}" class="link">4.年次決算</a><br>
      <a href="{{ route('manual.subject') }}" class="link">5.科目管理</a><br>
      <a href="{{ route('manual.account') }}" class="link">6.ユーザー管理</a>
    @endcan
  </div>
@endsection