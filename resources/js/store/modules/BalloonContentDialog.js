export const BalloonContentDialog = {
	namespaced: true,
	
	state: {
		visible: true,
		balloon: {"id":2,"content":"<p><span class=\"ql-size-huge\">Test test</span></p>","approved":1,"question_id":1,"created_at":"Wed, Oct 20, 2021 1:58 PM","updated_at":"2021-10-20T02:58:22.000000Z"}
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
