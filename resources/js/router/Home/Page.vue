<template>
	<div class="vRouterPage-home-page-container">
		<div class="main-page-content">
			<div class="top-bar">
				<h1>Fessona</h1>
				<router-link class="a" to="/about">About</router-link>
			</div>
			<p>/fə'səunə/</p>
			<p class="mt-10">(Roman mythology) Fessona is thought to be the goddess that cures fatigue.</p>
			<p class="mt-10">A soul-soothing collection of crowdsourced balloons 🎈</p>
			<a class="a mt-10" @click="toggleQuickstartDialogVisible(true)">How it works</a>

			<img src="/images/undraw_true_love_cy8x.svg" alt="Balls holding hands">
			
			<button class="btn primary full-width" v-ripple @click="toggleMoodSelectorDialogVisible(true)"><i class="fa fa-fighter-jet"></i>Start exploring</button>
			
			<p class="mt-20">Made with ❤️ by <a class="a" href="https://mixmav.me" target="_BLANK">Manav</a></p>
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
		}, 4000);
	},
	
	methods: {
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

		.top-bar{
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		img{
			display: block;
			width: 50%;
			margin: 30px auto;
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