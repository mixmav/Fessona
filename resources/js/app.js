require('./bootstrap');

import Vue from 'vue';
import Ripple from 'vue-ripple-directive';
import VueRouter from 'vue-router';
import VueScrollTo from 'vue-scrollto';
import VueCookie from 'vue-cookie';
import Toast from "vue-toastification";


Vue.use(Toast);
Vue.use(VueScrollTo);
Vue.use(VueCookie);

Ripple.color = 'rgba(255, 255, 255, 0.35)';
Vue.directive('ripple', Ripple);

import { store } from './store/store';
import routes from './routes';
import App from './App.vue';


const router = new VueRouter({
	mode: 'history',
	routes
});

new Vue({
	el: '#app',
	router,
	store,
	render: h => h(App)
});