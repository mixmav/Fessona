export const BalloonContentDialog = {
	namespaced: true,
	
	state: {
		visible: false,
		balloon: {},
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},
		updateBalloon(state, balloon){
			state.balloon = balloon;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},
		updateBalloon(context, balloon){
			context.commit('updateBalloon' ,balloon);
		}
	}
}
