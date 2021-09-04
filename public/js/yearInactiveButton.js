// $(function() {
//   $(function() {
//     $('#y_output').attr('disabled', 'disabled');
//       $('#inp_year').click(function() {
//       if ( $(this).prop('checked') == false ) {
//         $('#y_output').attr('disabled', 'disabled');
//       } else {
//         $('#y_output').removeAttr('disabled');
//       }
//     });
//   });
// });

// $(document).ready(function () {
//   const text = Number(document.getElementById("#inp_year")).value;
//   console.log(text);

//   $('.y_output').on('change', function () {
//     if (
//       $text.val() !== ""
//     ) {
//       $('.y_output').prop('disabled', false);

//     } else {
//       $('.y_output').prop('disabled', true);
//     }
//   });

// });

$(function() {
 
  // textボックスの変更時
  $('input[name=year]').keyup(function() {
    // valueを取得
    let val = $(this).val();
    console.log(val);

    if (
      val !== ""
    ) {
      $('.y_output').prop('disabled', false);
    } else {
      $('.y_output').prop('disabled', true);
    }
  });
});