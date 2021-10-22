export const BalloonContentDialog = {
	namespaced: true,
	
	state: {
		visible: true,
		balloonID: 1,
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},

		updateBalloonID(state, id){
			state.balloonID = id;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},

		updateBalloonID(context, id){
			context.commit('updateBalloonID' ,id);
		}
	}
}
