import { getField, updateField } from 'vuex-map-fields';

export const QuickstartDialog = {
	namespaced: true,
	
	state: {
		visible: false,
		dontShowOnStartup: false,
	},

	getters: {
		getField
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},
		updateDontShowOnStartup(state, value){
			state.dontShowOnStartup = value;
		},

		updateField
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},
	}
}
