export const ShareAnswerDialog = {
	namespaced: true,
	
	state: {
		visible: false,
		question: {
			prompt: 'Share your favorite music 🎶',
			prompt2: 'Why not share attach a YouTube video?'
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
