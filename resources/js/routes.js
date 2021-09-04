import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Home from './router/Home/Page.vue';
import BrowseSites from './router/BrowseSites/Page.vue';

const routes = [
	{
		path: '/',
		component: Home,
		name: 'Home'
	},
	{
		path: '/sites',
		component: BrowseSites,
		name: 'BrowseSites'
	},
]

export default routes;