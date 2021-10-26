@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>ユーザー管理マニュアル</h3>
    <hr>
    <a href="#account1" class="secList">ユーザー管理とは</a><br>
    <div id="account1" class="section">
      <ul>
        <li>ユーザーの登録や情報の更新を行います。</li>
        <li>アカウント無効にチェックをすると該当ユーザーのシステム利用を停止できます。</li>
        <li>管理者権限にチェックをすると該当ユーザーは管理者としてシステムを利用できます。</li>
      </ul>
    </div>
    <a href="#account2" class="secList">管理者の権限</a><br>
    <div id="account2" class="section">
      <ul>
        <li>管理者は「科目管理」や「ユーザー管理」の機能を使用できます。</li>
        <li>また、管理者権限がないユーザーは「科目管理」や「ユーザー管理」が表示されていません。</li>
      </ul>
    </div>
    <div>
      <a href="{{ route('manual.index') }}" class="btn btn-secondary btn-sm">マニュアル一覧へ戻る</a>
    </div>
  </div>
@endsection