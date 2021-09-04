$(function() {
  // numberボックスの変更時
  $('input[name=year]').change(function() {
    // valueを取得
    let val = $(this).val();
    if (
      val !== ""
    ) {
      $('.y_output').prop('disabled', false);
    } else {
      $('.y_output').prop('disabled', true);
    }
  });
});