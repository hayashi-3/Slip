$(".y_output").prop("disabled", true);

var select = document.querySelector("#year");
select.addEventListener('change', function(){
  selectedCheck();
})

function selectedCheck(){
  var city = $('#year').val();
  if(city !== "placeholder" ){
    $(".y_output").prop("disabled", false);
  }else{
    $(".y_output").prop("disabled", true);
  }
}