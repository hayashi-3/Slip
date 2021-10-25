@extends('layouts.app')

@section('content')
<div class="container">
  <h3>システム不具合かなと思ったら、まずこちらをご確認ください</h3>
  <hr>
  <a href="#defect1" class="secList">画面表示がおかしい</a><br>
  <div id="defect1" class="section">
    <ul>
      <li>このアプリケーションはブラウザをchromeにして使用することを前提に作成されています。</li>
      <li>お手数ですが、不具合がある場合は、ブラウザがchromeになっているかご確認をお願いいたします。</li>
      <li>chromeを使用しても不具合が解消されない場合は、恐れ入りますが、下記の連絡先へご連絡いただければと存じます。</li>
      <li>XXXXX@XXXX.co.jp</li>
    </ul>
  </div>
  <a href="#defect2" class="secList">パスワードを忘れた</a>
  <div id="defect2" class="section">
    <ul>
      <li>ログイン画面の「パスワードをお忘れですか？」のリンクからパスワードを再設定してください。</li>
    </ul>
  </div>
  <div>
    <a href="{{ route('manual.index') }}" class="btn btn-secondary btn-sm">マニュアル一覧へ戻る</a>
  </div>
</div>
@endsection