/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

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