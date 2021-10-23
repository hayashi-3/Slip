@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>月間仕訳マニュアル</h3>
    <hr>
    <a href="#month_s1" class="secList">月間仕訳とは</a><br>
    <div id="month_s1" class="section">
      <ul>
        <li>仕訳入力で入力したデータを科目ごとにまとめて金額を算出しています。</li>
        <li>10分毎に仕訳入力のデータを基にして更新されます。</li>
        <li>科目別の金額管理としてご利用ください。</li>
      </ul>
    </div>
    <div>
      <a href="{{ route('manual.index') }}">マニュアル一覧へ戻る</a>
    </div>
  </div>
@endsection