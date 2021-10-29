export const ShareAnswerDialog = {
	namespaced: true,
	
	state: {
		visible: false,
		question: {
			prompt: 'Share your favorite music',
			badges: ['something', 'something']
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
