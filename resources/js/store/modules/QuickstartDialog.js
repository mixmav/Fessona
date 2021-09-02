export const QuickstartDialog = {
	namespaced: true,
	
	state: {
		visible: false,
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		}
	}
}
