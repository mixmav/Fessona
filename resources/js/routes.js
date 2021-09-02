import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Home from './router/Home.vue';
import BrowseSites from './router/BrowseSites.vue';

const routes = [
	{
		path: '/',
		component: Home,
		name: 'Home'
	},
	{
		path: '/browse-sites',
		component: BrowseSites,
		name: 'BrowseSites'
	},
]

export default routes;