require('./bootstrap');

window.Vue = require('vue').default;

import axios from 'axios';

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Vuelidate from 'vuelidate';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuelidate)

import App from './App.vue';

import { routes } from './routes';

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

require('./mixins/global');

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
