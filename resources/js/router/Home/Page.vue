<template>
	<div class="vRouterPage-home-page-container">
		<div class="main-page-content">
			<h1>Fessona</h1>
			<p style="font-size: 1em">/fə'səunə/</p>
			<p class="mt-10">In Roman mythology, Fessona is thought to be the goddess that cures fatigue 🎈</p>
			
			<img src="/images/plant_in_hands.svg" alt="Hands holding a plant">
			<button class="btn mt-20" v-ripple v-tooltip.left="'Quickstart'" @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-info-circle"></i>How it works</button>
			&nbsp;
			<router-link class="btn red mt-20" to="/app" v-ripple><i class="fa fa-play-circle"></i>Launch</router-link>

		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';


export default {
	mounted(){
		this.quickStartTimeout = setTimeout(() => {
			if (!this.quickstartShownOnceOnHomePage && !this.quickstartDontShowOnStartup) {
				this.toggleQuickstartDialogVisible(true);
				this.updateQuickstartShownOnceOnHomePage(true);
			}
		}, 1000);
	},
	
	methods: {
		...mapActions('Alert', [
			'showAlert',
		]),
		
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),

		...mapActions([
			'updateQuickstartShownOnceOnHomePage',
		])
	},

	computed: {
		...mapState('QuickstartDialog', {
			quickstartDontShowOnStartup: 'dontShowOnStartup'
		}),

		...mapState([
			'quickstartShownOnceOnHomePage',
		]),
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
</style>