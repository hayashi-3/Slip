document.addEventListener('DOMContentLoaded', () => {
  // タブメニュークラス'.js-tab-trigger'を持つ要素を取得
  const tabTriggers = document.querySelectorAll('.js-tab-trigger');
  // タブコンテンツクラス'.js-tab-target'を持つ要素を取得
  const tabTargets = document.querySelectorAll('.js-tab-target');

  // 要素の数の分だけループ処理をして値を取り出す
  for (let i = 0; i < tabTriggers.length; i++) {
      // タブメニュークリック時
      tabTriggers[i].addEventListener('click', (e) => {
          // クリックされた要素（メニュー要素[トリガー要素]）を取得
          let currentMenu = e.currentTarget;
          // ターゲットとなる要素（タブメニューdata属性値と等しいid値を持つコンテンツ要素[ターゲット要素]）を取得
          let currentContent = document.getElementById(currentMenu.dataset.id);

          // すべてのタブメニューの'is-active'クラスを削除
          for (let i = 0; i < tabTriggers.length; i++) {
              tabTriggers[i].classList.remove('is-active');
          }
          // クリックしたタブメニューに'is-active'クラスを追加
          currentMenu.classList.add('is-active');

          // タブコンテンツを非アクティブにする
          for (let i = 0; i < tabTargets.length; i++) {
              tabTargets[i].classList.remove('is-active');
          }
          // 対象コンテンツ(指定したIDの要素があったら)を表示させる
          if(currentContent !== null) {
              currentContent.classList.add('is-active');
          }
      });
  }
});