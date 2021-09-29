<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<h1><span class="text-color primary">#</span> We asked</h1>
		<p class="text-color primary">{{question}}</p>

		<h3 class="mt-10">Here's what we heard</h3>
		
		<!-- <youtube :video-id="videoID"></youtube> -->

		<button class="btn red mt-10" v-ripple><i class="fa fa-dice"></i>Read at random</button>
		&nbsp;
		<button class="btn darkBlack mt-10" id="tourSteps-target-2" v-ripple><i class="fa fa-plus"></i>Share your answer</button>
		<div class="balloons custom-scrollbar">
			<div class="balloon no-select" v-ripple v-for="i in 8" :key="i" :style="generateBalloonStyle(i)" @mouseover="synthSound(i)">
				{{ i }}
			</div>
		</div>
	</div>
</template>

<script>
// import * as Tone from 'tone'

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
			let color = `rgba(${red}, ${green}, ${blue}, 0.8)`;
			
			let delay = _.random(0, 2, true);
			let duration = _.random(0.5, 1, true);
			return `
				background: ${color};
				border: solid 2px ${color};
				animation-delay: ${delay}s;
				animation-duration: ${duration}s;
			`;
		},

		synthSound(i){
			// this.synth.triggerAttack(i*100, Tone.now());
		},
		// computed: {
		// 	// videoID(){
		// 		// return this.$youtube.getIdFromURL("https://www.youtube.com/watch?v=pA96m95T3NA&t=4211s&ab_channel=Cercle");
		// 	// }
		// },
	},
}
</script>

<style lang="scss">
	
@import "../../../scss/variables";

.vRouterPageComponent-App-balloon-section-container{
	margin-top: 50px;
	h1{
		font-size: 1.5em;
	}
	p{
		font-size: 1em;
	}
	.balloons{
		margin-top: 20px;
		overflow-x: scroll;
		padding: 1em;
		white-space: nowrap;
		.balloon{
			width: 100px;
			height: 100px;
			background: $green;
			display: inline-flex;
			justify-content: center;
			align-items: center;
			color: white;
			border-radius: 100%;
			margin-left: 10px;
			cursor: pointer;
			// transition: all .2s;
			animation: ballonUpDown 1s infinite;
			&:hover{
				transform: scale(1.1, 1.1);
			}
		}
	}
}

@keyframes ballonUpDown{
	from {
		transform: translateY(0);
	} 25%{
		transform: translateY(-5px);
	} 50%{
		transform: translateY(0);
	} 75%{
		transform: translateY(5px);
	} to {
		transform: translateY(0);
	}
}
</style>