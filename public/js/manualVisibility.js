$(function(){
  $('.section').hide();

  $('.secList').on('click',function(){
    $('.section').not($($(this).attr('href'))).hide();

    // フェードイン・アウトのアニメーション付で、表示・非表示を交互に実行する
    $($(this).attr('href')).fadeToggle(1000);

  });
});