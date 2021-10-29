export const MoodSelectorDialog = {
	namespaced: true,
	
	state: {
		visible: false,
		selectedMood: {},
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},
		updateSelectedMood(state, newMood){
			state.selectedMood = newMood;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},
		updateSelectedMood(context, newMood){
			context.commit('updateSelectedMood', newMood);
		}
	}
}
