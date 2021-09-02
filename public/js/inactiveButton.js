$(".excel_btn").prop("disabled", true);

var select = document.querySelector(".select");
select.addEventListener('change', function(){
  selectedCheck();
})

function selectedCheck(){
  var city = $('select').val();
  if(city !== "placeholder" ){
    $(".excel_btn").prop("disabled", false);
  }else{
    $(".excel_btn").prop("disabled", true);
  }
}