function localstr(str){
  var wstr = str.value;
  // 入力されたカンマを消去
  var wnum = new String(wstr).replace(/,/g, "");
  // 数値に変換
  var wstr = Number(wnum);
  // ３桁ごとにカンマ付加
  var wnum = wstr.toLocaleString("jp",{maximumFractionDigits:5});
  document.getElementById("localstr").value=wnum;
  return(str);
}