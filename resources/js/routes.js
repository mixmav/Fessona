import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Home from './router/Home/Page.vue';
import App from './router/App/Page.vue';

const routes = [
	{
		path: '/',
		component: Home,
		name: 'Home'
	},
	{
		path: '/app',
		component: App,
		name: 'App'
	},
]

export default routes;