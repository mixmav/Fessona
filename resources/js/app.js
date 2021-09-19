require('./bootstrap');

import Vue from 'vue';
import Ripple from 'vue-ripple-directive';
import VueRouter from 'vue-router';
import VTooltip from 'v-tooltip';
import VueScrollTo from 'vue-scrollto';
import VueCookie from 'vue-cookie';

Vue.use(VueScrollTo);
Vue.use(VueCookie);
//Remove the arrow from the template
Vue.use(VTooltip, {
	defaultTemplate: '<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>'
});
Ripple.color = 'rgba(255, 255, 255, 0.35)';
Vue.directive('ripple', Ripple);

import { store } from './store/store';
import routes from './routes';
import App from './App.vue';


const router = new VueRouter({
	routes
});

new Vue({
	el: '#app',
	router,
	store,
	render: h => h(App)
});