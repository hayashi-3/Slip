window.addEventListener('DOMContentLoaded', function(){

  // テキストエリアのHTML要素を取得
  var textarea_contact = document.getElementById("inp_year");

  // イベント「change」を登録
  textarea_contact.addEventListener("change",function(){
    console.log("Change action");
    console.log(this.value);
  });

  // イベント「input」を登録
  textarea_contact.addEventListener("input",function(){
    console.log("Input action");
    console.log(this.value);
  });

});