$(function(){
  // 編集ボタンクリック処理
  $('.edit-line').click(function(){
      $(this).parents('.data-edit').find("[class$='_value']").toggle(false);
      $(this).parents('.data-edit').find("[class$='_change']").toggle(true);
  });
  // 保存ボタンクリック処理
  $('.save-line').click(function(){
      $(this).parents('.data-edit').find("[class$='_value']").toggle(false);
      $(this).parents('.data-edit').find("[class$='_change']").toggle(true);
  });
  // キャンセルボタンクリック処理
  $('.cancel-line').click(function(){
      $(this).parents('.data-edit').find("[class$='_value']").toggle(true);
      $(this).parents('.data-edit').find("[class$='_change']").toggle(false);
  });

  $("[class$='_value']").toggle(true);
  $("[class$='_change']").toggle(false);
});