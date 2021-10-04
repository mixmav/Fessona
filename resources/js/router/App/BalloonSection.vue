<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<p class="text-color primary">{{question}}</p>
		
		<!-- <youtube :video-id="videoID"></youtube> -->

		<button class="btn mt-10" id="tourSteps-target-2" v-ripple @click="toggleShareAnswerDialogVisible(true)"><i class="fa fa-plus"></i>Share your answer</button>
		<div class="balloons custom-scrollbar">
			<div class="balloon no-select" v-for="i in 8" :key="i" :style="generateBalloonStyle(i)" @mouseover="synthSound(i)" @click="toggleBallonContentDialogVisible(true)">
				<i class="fab fa-youtube"></i>
			</div>
		</div>
	</div>
</template>

<script>
// import * as Tone from 'tone'
import { mapActions, mapState } from 'vuex';

export default {
	mounted(){
		// this.synth = new Tone.PolySynth(Tone.Synth).toDestination();
		// this.synth.triggerAttackRelease("C4", "8n");
	},

	beforeDestroy(){

	},
	props: [
		'question'
	],
	data(){
		return {
			synth: {},
		}
	},
	methods: {
		generateBalloonStyle(i){
			let red = _.random(0, 255);
			let green = _.random(0, 255);
			let blue = _.random(0, 255);

			let width = _.random(50, 100);

			return `
				background: rgba(${red}, ${green}, ${blue}, 0.7);
				border: solid 2px rgb(${red}, ${green}, ${blue});
				width: ${width}px;
				height: ${width}px;
			`;
		},

		...mapActions('ShareAnswerDialog', {
			toggleShareAnswerDialogVisible: 'toggleVisible',
		}),

		...mapActions('BalloonContentDialog', {
			toggleBallonContentDialogVisible: 'toggleVisible',
		}),

		synthSound(i){
			// this.synth.triggerAttack(i*100, Tone.now());
		},
	},
}
</script>

<style lang="scss">
	
@import "../../../scss/variables";

.vRouterPageComponent-App-balloon-section-container{
	width: 100%;
	max-width: 600px;
	margin: 0 auto;
	p{
		font-size: 1.4em;
	}
	.balloons{
		margin-top: 20px;
		padding: 1em;
		.balloon{
			background: $green;
			display: inline-flex;
			justify-content: center;
			align-items: center;
			color: white;
			border-radius: 100%;
			margin-left: 10px;
			margin-top: 10px;
			cursor: pointer;
			transition: all .2s;
			&:hover{
				transform: scale(1.1, 1.1);
			}
		}
	}
}
</style>