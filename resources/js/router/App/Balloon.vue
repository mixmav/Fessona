<template>
	<div class="vRouterPageComponent-App-balloon-container">
		<h1># We asked</h1>
		<p>What's one YouTube video that never fails to cheer you up?</p>

		<h3 class="mt-10">Here's what we heard</h3>
		<!-- <youtube :video-id="videoID"></youtube> -->
		
		<div class="balloons custom-scrollbar">
			<div class="balloon" v-for="i in 100" :key="i" :style="generateBalloonStyle(i)" @mouseover="synthSound(i)"></div>
		</div>
	</div>
</template>

<script>
// import * as Tone from 'tone'

export default {
	methods: {
		generateBalloonStyle(i){
			let red = Math.floor(Math.random() * 255);
			let green = Math.floor(Math.random() * 255);
			let blue = Math.floor(Math.random() * 255);
			let color = `rgba(${red}, ${green}, ${blue}, 0.8)`;
			return `
				background: ${color};
				border: solid 2px ${color};
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
		mounted(){
			// this.synth = new Tone.PolySynth(Tone.Synth).toDestination();
			// this.synth.triggerAttackRelease("C4", "8n");
		},

		beforeDestroy(){

		},
		data(){
			return {
				synth: {},
			}
		}
	}
}
</script>

<style lang="scss">
	
@import "../../../scss/variables";

.vRouterPageComponent-App-balloon-container{
	margin-top: 30px;
	.balloons{
		margin-top: 20px;
		overflow-x: scroll;
		padding: 1em;
		white-space: nowrap;
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
}
</style>