<template>
	<div class="vRouterPage-browse-sites-page-container">
		<div class="main-page-content mt-60">
			<h1>Actve sites</h1>
			<p>Each box below represents a real location at an RMIT Campus filled with community-generated content.</p>
			<p class="mt-10">Pick one to leave your own! <i class="fa fa-hand-point-down"></i></p>
			<div class="active-sites">
				<Flicking ref="flicking" :plugins="plugins" :options="options" @visible-change="triggerVisibleChange">
					<div class="site">1</div>
					<div class="site">2</div>
					<div class="site">3</div>
					<div slot="viewport" class="flicking-pagination"></div>
				</Flicking>
			</div>
			<button class="btn full-width mt-30" v-ripple><i class="fa fa-random"></i>Get a random message</button>
			
			<router-link to="/" class="btn darkBlack mt-20" v-ripple><i class="fa fa-igloo"></i>Back home</router-link>
		</div>
	</div>
</template>

<script>
import { Pagination } from "@egjs/flicking-plugins";
import { Flicking, FlickingError, ERROR_CODE } from "@egjs/vue-flicking";
import * as Tone from 'tone'

export default {
	data(){
		return {
			plugins: [new Pagination({ type: 'bullet' })],
			options: {
				inputType: ['touch', 'pointer', 'mouse'],
				interruptable: true,
			}
		}
	},
	
	components: {
		Flicking: Flicking
	},

	async mounted(){
		try {
			await this.$refs.flicking.next();
		} catch (err) {
			alert(err);
		}
	},

	methods: {
		triggerVisibleChange(event){
			console.log(event);
			const synth = new Tone.Synth().toDestination();
			synth.triggerAttackRelease("C4", "8n");
		}
	}
}

</script>

<style lang="scss">
@import "../../scss/variables";

.vRouterPage-browse-sites-page-container{
	.flicking-pagination{
		position: relative;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		transform: none;
		margin: 10px auto;
		.flicking-pagination-bullet{
			width: 15px;
			height: 15px;
			&:hover{
				background: rgba($red, 0.6);
			}
		}
		.flicking-pagination-bullet-active{
			background: $red;
		}
	}

	.active-sites{
		margin-top: 10px;
		.site{
			width: 80%;
			border-radius: 10px;
			height: 200px;
			margin-left: 10px;
			cursor: pointer;
			background: $red;
			&:nth-child(even){
				background: $yellow;
			}
		}
	}
}

</style>
