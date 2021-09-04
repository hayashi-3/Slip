$(".excel_btn").prop("disabled", true);

var select = document.querySelector(".select");
select.addEventListener('change', function(){
  selectedCheck();
})

function selectedCheck(){
  var year = $('select').val();
  if(year !== "placeholder" ){
    $(".excel_btn").prop("disabled", false);
  }else{
    $(".excel_btn").prop("disabled", true);
  }
}