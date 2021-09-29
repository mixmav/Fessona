<template>
	<div class="vRouterPage-browse-sites-page-container">
		
		<div class="main-page-content">
			<div class="top-bar">
				<router-link to="/">Fessona</router-link>
				<button class="btn" v-ripple @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-info-circle"></i>How it works</button>
			</div>

			<div class="page-content custom-scrollbar">
				<balloon-section v-for="i in ballonSections" :key="i.id" id="tourSteps-target-1" :question="i.question"></balloon-section>

				<v-tour name="introductionTour" :steps="tourSteps" :options="{highlight: true}"></v-tour>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex';
import $ from 'jquery';
import BalloonSection from './BalloonSection.vue';

export default {
	components: {
		BalloonSection,
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

			ballonSections: [
				{
					id: 0,
					question: "What's one YouTube video that never fails to cheer you up?",
				},
				{
					id: 1,
					question: "What makes you feel grounded?",
				},
				{
					id: 2,
					question: "Fav hype anthem",
				},
			]
		}
	},

	methods: {
		...mapActions('Alert', [
			'showAlert'
		]),

		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),

		...mapActions([
			'updatePageScrolled',
		]),
	},
	mounted(){
		// this.$tours['introductionTour'].start();

		var $window = $('.page-content');
		$window.on('scroll', (event) => {
			if ($window.scrollTop() > 80){
				this.updatePageScrolled(true);
			} else {
				this.updatePageScrolled(false);
			}
		});
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
			border-bottom: solid 1px rgba(black, 0.4);

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
		padding: 10px;
		.v-step__header{
			color: white !important;
		}
		.v-step__content{
			color: white !important;
		}
	}
}
@keyframes backgroundToWhite {
	to{
		background: white;
	}
}
</style>
