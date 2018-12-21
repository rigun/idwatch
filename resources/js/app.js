
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
import router from './routes.js';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css';

window.Slug = require('slug');
Slug.defaults.mode = 'rfc3986';
window.VueRouter = require('vue-router').default;

Vue.use(VueRouter);
Vue.use(Vuetify);


const AppLayout = Vue.component('app-layout', require('./components/appLayout.vue'))
const slugWidget = Vue.component('slug-widget', require('./components/slugWidget.vue'));

new Vue(
    Vue.util.extend(
        {router},
        AppLayout,
        slugWidget,
    )
).$mount('#mainLayout');
