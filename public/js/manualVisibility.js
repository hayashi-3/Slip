$(function() {
 
  // リンクをクリックしたら発動
  $('.chrome').click(function() {
    // 連打で暴走しないようにstop()も設定
    $('.invisible').stop().fadeToggle(1000);
  });

	$('.pass').click(function() {
    $('.pass_text').stop().fadeToggle(1000);
  });
	
});