/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
// import Vue from 'vue';
import Vue from 'vue';
import VueRouter from 'vue-router';
import { BootstrapVue } from 'bootstrap-vue'
import { routes } from './routes';
import Pagination from 'vue-pagination-2';
import Toasted from 'vue-toasted'

Vue.component('pagination', Pagination);
Vue.component('login' , require('./components/login.vue').default);

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(Toasted)

const app = new Vue({
    el: '#app',
    router: new VueRouter({ mode: 'history', routes }),
});
