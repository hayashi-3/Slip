function confirm_alert(e){
  if(!window.confirm('年次決算を確定します')){
     window.alert('キャンセルされました'); 
     return false;
  }
  document.c_year.submit();
};