// window.addEventListener('DOMContentLoaded', function(){
//   // リンクをクリックしたら発動
//   $('.chrome').click(function() {
//     // 連打で暴走しないようにstop()も設定
//     $('.invisible').stop().fadeToggle(1000);
//   });

// 	$('.pass').click(function() {
//     $('.pass_text').stop().fadeToggle(1000);
//   });

//   $('.m_summary_manual').click(function() {
//     $('.m_text').stop().fadeToggle(1000);
//   });

//   $('.register_slip').click(function() {
//     $('.register_slip_text').stop().fadeToggle(1000);
//   });
// });

$(function(){
  $('.section').hide();

  $('.secList').on('click',function(){
    $('.section').not($($(this).attr('href'))).hide();

    // フェードイン・アウトのアニメーション付で、表示・非表示を交互に実行する
    $($(this).attr('href')).fadeToggle(1000);

    // show を使うと、表示するだけ （ 同じボタンを何回押しても変わらない ）
    // $($(this).attr('href')).show();
  });
});