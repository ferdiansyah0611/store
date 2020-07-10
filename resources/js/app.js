/*integrated lodash, popper, jquery, bootstrap, admin-lte@^3.0, axios & vue*/
require('./bootstrap');
window.Vue = require('vue');
/*import vue*/
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import Vuex from 'vuex';
/*instance*/
Vue.use(VueRouter, VueAxios, Axios);
/*component*/
Vue.component('pagination', require('laravel-vue-pagination'));
/*app, route & store*/
import App from './page/App.vue';
import Routing from './url.js';
import Store from './store.js';
const router = new VueRouter({
    mode: 'history',
    routes: Routing
});
const app = new Vue(
    Vue.util.extend({
        router,
        store: Store
    }, App)
).$mount('#app');