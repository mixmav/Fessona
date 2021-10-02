import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import { Alert } from './modules/Alert';
import { QuickstartDialog } from './modules/QuickstartDialog';
import { MoodSelectorDialog } from './modules/MoodSelectorDialog';

export const store = new Vuex.Store({
	strict: process.env.NODE_ENV !== 'production',

	modules: {
		Alert: Alert,
		QuickstartDialog: QuickstartDialog,
		MoodSelectorDialog: MoodSelectorDialog,
	},

	state: {
		pageScrolled: false,
	},

	mutations: {
		updatePageScrolled(state, value){
			state.pageScrolled = value;
		}
	},

	actions: {
		updatePageScrolled(context, value){
			context.commit('updatePageScrolled', value);
		}
	}
});
