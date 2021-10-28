<template>
	<div id="app-container">
		<div class="main-content">
			<!-- <div id="particles-js"></div> -->
			<particles id="particles-js-main" container=".main-page-content"></particles>
			<transition name="opacity">
				<quickstart-dialog v-show="quickstartDialogVisible"></quickstart-dialog>
			</transition>
		
			<transition name="opacity">
				<mood-selector-dialog v-show="moodSelectorDialogVisible"></mood-selector-dialog>
			</transition>

			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>

			
			<transition name="opacity">
				<share-answer-dialog v-show="shareAnswerDialogVisible"></share-answer-dialog>
			</transition>

			<transition name="opacity">
				<balloon-content-dialog v-show="balloonContentDialogVisible"></balloon-content-dialog>
			</transition>

			<go-to-top></go-to-top>
		</div>
	</div>
</template>

<script>
import GoToTop from './components/GoToTop.vue';
import Particles from './components/ParticlesJS.vue';

import QuickstartDialog from './components/QuickstartDialog.vue';
import MoodSelectorDialog from './components/MoodSelectorDialog.vue';

import BalloonContentDialog from './components/BalloonContentDialog.vue';
import ShareAnswerDialog from './components/ShareAnswerDialog.vue';



import { mapState, mapActions } from 'vuex';

export default {
	components: {
		GoToTop,
		QuickstartDialog,
		MoodSelectorDialog,
		BalloonContentDialog,
		ShareAnswerDialog,
		Particles
	},

	mounted(){
		// For mobile browsers, if the user navigates while the dialog is open, close it.
		this.$router.beforeEach((from, to, next) => {
			if (this.quickstartDialogVisible) {
				this.updateQuickstartDialogVisible(false);
			}
			next();
		});
	},

	beforeDestroy() {
		document.querySelector('.main-page-content').removeEventListener('mousemove')
	},
	methods: {
		...mapActions('QuickstartDialog', {
			updateQuickstartDialogVisible: 'toggleVisible',
		}),
	},

	computed: {
		...mapState('QuickstartDialog', {
			quickstartDialogVisible: 'visible',
		}),
		
		...mapState('MoodSelectorDialog', {
			moodSelectorDialogVisible: 'visible',
		}),

		...mapState('ShareAnswerDialog', {
			shareAnswerDialogVisible: 'visible',
		}),

		...mapState('BalloonContentDialog', {
			balloonContentDialogVisible: 'visible'
		}),
	}
};
</script>

<style lang="scss">
@import "../scss/variables";


#app-container {
    & > .main-content {
		.main-page-content{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			width: 100%;
			text-align: left;
        	padding: 1em;
			overflow: auto;
			z-index: $zIndex-router-content;
		}

		.particles-js{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 0;
		}
    }
}
</style>