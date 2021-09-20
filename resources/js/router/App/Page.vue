<template>
	<div class="vRouterPage-browse-sites-page-container">
		
		<div class="main-page-content">
			<div class="top-bar">
				<router-link to="/">Fessona</router-link>
				<button class="btn" v-ripple v-tooltip.left="'Quickstart'" @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-info-circle"></i>How it works</button>
			</div>

			<div class="page-content custom-scrollbar">
				<balloon v-for="i in 20" :key="i" id="tourSteps-target-1"></balloon>

				<v-tour name="introductionTour" :steps="tourSteps" :options="{highlight: true}"></v-tour>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex';
import $ from 'jquery';
import Balloon from './Balloon.vue';

export default {
	components: {
		Balloon,
	},
	data(){
		return {
			tourSteps: [
				{
					target: '#tourSteps-target-1',
					header: {
						title: 'Get Started',
					},
					content: `Discover <strong>Vue Tour</strong>!`,
					// params: {
					// 	highlight: false
					// }
				}
			],
		}
	},

	methods: {
		...mapActions('Alert', [
			'showAlert'
		]),

		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),
	},
	mounted(){
		// this.$tours['introductionTour'].start();
	},
}

</script>

<style lang="scss">
@import "../../../scss/variables";

.vRouterPage-browse-sites-page-container{
	.main-page-content{
		background: transparent;
		animation: backgroundToWhite linear .3s;
		animation-delay: .3s;
		animation-fill-mode: forwards;
		padding: 0 !important;
		.top-bar{
			width: 100%;
			display: flex;
			justify-content: space-between;
			position: fixed;
			top: 0;
			left: 0;
			padding: 1em;
			background: white;
			border-bottom: solid 1px black;

			a{
				text-decoration: none;
				font-size: 2em;
			}
		}

		.page-content{
			padding: 1em {
				top: 0;
			};
			position: fixed;
			top: 78px;
			left: 0;
			width: 100%;
			height: calc(100% - 70px);
			overflow: scroll;
		}
	}
	.v-tour__target--highlighted {
		box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
	}
}
@keyframes backgroundToWhite {
	to{
		background: white;
	}
}
</style>
