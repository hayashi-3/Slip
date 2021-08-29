jQuery(function($){
  $('td').click(function(){
      //classでonを持っているかチェック
      if(!$(this).hasClass('on')){
          //編集可能時はclassでonをつける
          $(this).addClass('on');
          var txt = $(this).text();
          //テキストをinputのvalueに入れてで置き換え
          $(this).html('<input type="text" value="'+txt+'" />');
          //同時にinputにフォーカスをする
          $('td > input').focus().blur(function(){
              var inputVal = $(this).val();
              //もし空欄だったら空欄にする前の内容に戻す
              if(inputVal===''){
                  inputVal = this.defaultValue;
              };
              //編集が終わったらtextで置き換える
              $(this).parent().removeClass('on').text(inputVal);
          });
      };
  });
});