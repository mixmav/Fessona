<template>
	<div class="vRouterPage-home-page-container">
		<div class="main-page-content">
			<h1>Fessona</h1>
			<p style="font-size: 1em">/fə'səunə/</p>
			<p class="mt-10">In Roman mythology, Fessona is thought to be the goddess that cures fatigue 🎈</p>
			
			<img src="/images/plant_in_hands.svg" alt="Hands holding a plant">
			<button class="btn mt-30" v-ripple @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-charging-station"></i>How it works</button>
			&nbsp;

			<button class="btn yellow mt-30" v-ripple @click="toggleMoodSelectorDialogVisible(true)"><i class="fa fa-play-circle"></i>Start</button>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';


export default {
	mounted(){
		this.quickStartTimeout = setTimeout(() => {
			if (!this.quickstartDontShowOnStartup && !this.quickstartShownOnceOnHomePage) {
				this.toggleQuickstartDialogVisible(true);
			}
		}, 5000);
	},
	
	methods: {
		...mapActions('Alert', [
			'showAlert',
		]),
		
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),

		...mapActions('MoodSelectorDialog', {
			toggleMoodSelectorDialogVisible: 'toggleVisible'
		})
	},

	computed: {
		...mapState('QuickstartDialog', {
			quickstartDontShowOnStartup: 'dontShowOnStartup',
			quickstartShownOnceOnHomePage: 'shownOnceOnHomePage',
		}),
	},

	data(){
		return {
			quickStartTimeout: {},
		}
	},

	beforeDestroy(){
		//If the user navigates away before the dialog is visible, clear the timeout.
		clearTimeout(this.quickStartTimeout);
	}
}

</script>

<style lang="scss">

@import "../../../scss/variables";

.vRouterPage-home-page-container{
	display: flex;
	justify-content: center;
	.main-page-content{
		max-width: 500px;
		margin-top: 100px;
		position: relative !important;

		img{
			display: block;
			width: 50%;
			margin-top: 30px;
			height: auto;
		}
	}
}

@include media(400px){
	.vRouterPage-home-page-container{
		.main-page-content{
			img{
				width: 65%;
			}
		}
	}
}

@include media-y(570px){
	.vRouterPage-home-page-container{
		.main-page-content{
			margin-top: 20px;
		}
	}
}
</style>