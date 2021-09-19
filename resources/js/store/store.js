import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import { Alert } from './modules/Alert';
import { QuickstartDialog } from './modules/QuickstartDialog';

export const store = new Vuex.Store({
	strict: process.env.NODE_ENV !== 'production',

	modules: {
		Alert: Alert,
		QuickstartDialog: QuickstartDialog,
	},

	state: {
		quickstartShownOnceOnHomePage: false,
	},

	mutations: {
		updateQuickstartShownOnceOnHomePage(state, value){
			state.quickstartShownOnceOnHomePage = value;
		}
	},

	actions: {
		updateQuickstartShownOnceOnHomePage(context, value){
			context.commit('updateQuickstartShownOnceOnHomePage', value);
		}
	}
});
