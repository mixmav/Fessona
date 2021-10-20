export const ShareAnswerDialog = {
	namespaced: true,
	
	state: {
		visible: true,
		question: {
			prompt: 'Share something that makes you smile'
		},
	},

	mutations: {
		toggleVisible(state, visibility){
			state.visible = visibility;
		},
		updateQuestion(state, question){
			state.question = question;
		}
	},

	actions: {
		toggleVisible(context, visibility){
			context.commit('toggleVisible', visibility);
		},
		updateQuestion(context, question){
			context.commit('updateQuestion', question);
		},
	}
}
