@extends('layouts.app')

@section('content')
<div class="container">
  <h3>科目管理マニュアル</h3>
  <hr>
  <a href="#subject1" class="secList">仕訳科目登録方法</a><br>
  <div id="subject1" class="section">
    <ul>
      <li>仕訳科目を登録できます。</li>
      <li>掛け率も登録することができます。</li>
      <li>家賃など全額を計上するものではない場合はこちらで掛け率を登録してください。</li>
      <li>全額計上するものは掛け率を1としてください。</li>
    </ul>
  </div>
  <a href="#subject2" class="secList">仕訳科目登録の反映のタイミングと利用について</a><br>
  <div id="subject2" class="section">
    <ul>
      <li>登録した科目は仕訳入力にて即時に反映されます。</li>
      <li>登録した掛け率で計算して登録ができます。詳しくは<a href="{{ route('manual.slip') }}">仕訳入力のマニュアル</a>をご参照ください。</li>
    </ul>
  </div>
  <div>
    <a href="{{ route('manual.index') }}" class="btn btn-secondary btn-sm">マニュアル一覧へ戻る</a>
  </div>
</div>
@endsection