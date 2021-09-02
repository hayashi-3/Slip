@extends('layouts.app')

@section('content')
<div class="container">
  <h3>システム不具合かなと思ったら、まずこちらをご確認ください</h3>
  <hr>
  <a class="chrome">ボタンが表示されない</a><br>
  <div class="invisible">
    <ul>
      <li>このアプリケーションはブラウザをchromeにして使用することを前提に作成されています。</li>
      <li>お手数ですが、不具合がある場合は、ブラウザがchromeになっているかご確認をお願いいたします。</li>
      <li>chromeを使用しても不具合が解消されない場合は、恐れ入りますが、下記の連絡先へご連絡いただければと存じます。</li>
      <li>XXXXX@XXXX.co.jp</li>
    </ul>
  </div>
  <a class="pass">パスワードを忘れた</a>
  <div class="pass_text">
    <ul>
      <li>ログイン画面の「パスワードをお忘れですか？」のリンクからパスワードを再設定してください。</li>
    </ul>
  </div>
</div>
@endsection