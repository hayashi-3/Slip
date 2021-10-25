@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>年次決算マニュアル</h3>
    <hr>
    <a href="#years_s1" class="secList">年次決算とは</a><br>
    <div id="years_s1" class="section">
      <ul>
        <li>1年の仕訳を確定します。</li>
        <li>該当の年度の伝票を登録します。</li>
        <li>
          こちらは仕訳入力のデータを基にして年次決算を行うので、年次決算を実行した段階で仕訳入力されている伝票が対象です。
        </li>
      </ul>
    </div>
    <a href="#years_s2" class="secList">年次確定処理</a><br>
    <div id="years_s2" class="section">
      <ul>
        <li>年次決算処理を行いたい年度を選択して「年次決算を出力する」ボタンを押すと科目ごとの合計金額が算出されます。</li>
        <li>年次決算を出力しただけでは、年次決算は確定していませんので、金額の修正を行うことが可能です。</li>
        <li>金額修正を行う際は仕訳入力から伝票を入力して、再度、年次決算を出力してください。</li>
        <li>※データの不整合を防ぐため、仕訳入力から年次決算の手順を守ってください。手順を守らないと、エクセル出力が上手くいきません。</li>
        <li>金額の端数などを調整したい場合は、編集することが可能です。</li>
        <li>各年度のタブ内に「年次決算を確定する」ボタンがあります。こちらを押すことで、年次決算が確定し、データを編集することができなくなります。</li>
      </ul>
    </div>
    <a href="#years_s3" class="secList">エクセル出力</a>
    <div id="years_s3" class="section">
      <ul>
        <li>年度を選択するとエクセルで1年分の明細を出力できます。</li>
      </ul>
    </div>
    <div>
      <a href="{{ route('manual.index') }}" class="btn btn-secondary btn-sm">マニュアル一覧へ戻る</a>
  </div>
  </div>
@endsection