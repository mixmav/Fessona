export const MoodSelectorDialog = {
	namespaced: true,
	
	state: {
		visible: true,
		selectedMood: {},
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},
		updateSelectedMood(state, moodID){
			state.selectedMood = moodID;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},
		updateSelectedMood(context, moodID){
			context.commit('updateSelectedMood', moodID);
		}
	}
}
