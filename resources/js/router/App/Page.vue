<template>
	<div class="vRouterPage-browse-sites-page-container">
		
		<div class="main-page-content">
			<div class="top-bar">
				<button class="btn" v-ripple v-tooltip.left="'Quickstart'" @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-info-circle"></i>How it works</button>
			</div>

			<div class="page-content">
				<h1>We asked</h1>
				<p>What's one YouTube video that never fails to cheer you up?</p>

				<h3 class="mt-10">Here's what we heard</h3>
				<!-- <youtube :video-id="videoID"></youtube> -->
				
				<div class="balloons" id="tourSteps-target-1">
					<div class="balloon" v-for="i in 10" :key="i" :style="generateBalloonStyle(i)"></div>
				</div>

				<router-link to="/" class="btn darkBlack mt-50" v-ripple><i class="fa fa-igloo"></i>Back home</router-link>
				<v-tour name="introductionTour" :steps="tourSteps" :options="{highlight: true}"></v-tour>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex';
import $ from 'jquery';

export default {
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
			]
		}
	},

	mounted(){
		this.$tours['introductionTour'].start()
	},

	methods: {
		...mapActions('Alert', [
			'showAlert'
		]),

		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),

		generateBalloonStyle(i){
			let red = Math.floor(Math.random() * 255);
			let green = Math.floor(Math.random() * 255);
			let blue = Math.floor(Math.random() * 255);
			let color = `rgba(${red}, ${green}, ${blue}, 0.8)`;
			return `
				background: ${color};
				border: solid 2px ${color};
			`;
		}
	},

	computed: {
		// videoID(){
			// return this.$youtube.getIdFromURL("https://www.youtube.com/watch?v=pA96m95T3NA&t=4211s&ab_channel=Cercle");
		// }
	}
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
			justify-content: flex-end;
			padding: 1em;
		}

		.page-content{
			padding: 1em;

			.balloons{
				margin-top: 10px;
				.balloon{
					width: 100px;
					height: 100px;
					background: $green;
					display: inline-block;
					border-radius: 100%;
					margin-left: 10px;
					cursor: pointer;
					transition: all .2s;
					&:hover{
						transform: scale(1.1, 1.1);
					}
				}
			}
			.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}
		}
	}
}
@keyframes backgroundToWhite {
	to{
		background: white;
	}
}
</style>
