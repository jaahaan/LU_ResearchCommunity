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

//Mixins are a flexible way to distribute reusable functionalities for Vue components.
Vue.mixin(common)

let authUser = window.authUser

router.beforeEach((to, from, next) => {
    document.title = to.meta.title

    if(to.meta){
        let allowed = to.meta.allowed

        if(allowed == 1){
            return next();
        }
        
        else if(allowed == 2){
            if(authUser){
                return next()
            }
            else{
                return next({name: 'login'})
            }
        }
        else if(allowed == 3){
            if(!authUser){
                return next()
            }
            
        }
    }
});

//Vue.config is an object containing Vue’s global configurations.
//Set this to false to prevent the production tip on Vue startup.
Vue.config.productionTip = false
Vue.component('default', require('./layout/default.vue').default);
Vue.component('auth', require('./layout/auth.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store: store,
});
