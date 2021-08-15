// まずBを非表示にする
$('#cal > option[data-id]').wrap('<span>');
 
$('#subject').change(function () {
  // Aが変更されるときに一度非表示にする
  $('#cal > option[data-id]').wrap('<span>');
  // Aのvalueに対応するBのdata-idのoptionを表示する
  $("#cal option[data-id='"+ $('#subject').val() +"']").unwrap();
});