/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import iView from 'iview';
import locale from 'iview/dist/locale/en-US';
import router from './router';
import store from './store';
Vue.use(iView, { locale : locale });

import common from './plugin/common';
Vue.mixin(common)

// 
// let authUser = window.authUser;
// 
// router.beforeEach((to, from, next) => {
//     document.title = to.meta.title
//     if(to.meta){
//         let allowed = to.meta.allowed
//         if(allowed == 1){
//             next()
//         }
//         else if(allowed == 2){
//             if(authUser){
//                 next()
//             }
//             else{
//                 next({name: 'login'})
//             }
//         }
//         else if(allowed == 3){
//             if(authUser){
//                 next({name: 'index'})
//             }
//             else{
//                 next()
//             }
//         }
//     }
//     return
// 
// 
// });


Vue.config.productionTip = false
Vue.component('default', require('./layout/default.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store: store,
});
