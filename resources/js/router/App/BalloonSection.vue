<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<div class="prompts">
			<h1><i class="far fa-bookmark"></i>We asked</h1>
			<p class="text-decor primary">{{question.prompt}}</p>
			<button class="btn mt-10" id="tourSteps-target-2" v-ripple @click="showShareAnswerDialog"><i class="fa fa-plus"></i>Share your answer</button>
		</div>
		
		<div style="text-align: center" v-show="loading" class="mt-30">
			<p>Fetching balloons ⚡</p>
			<loading class="mt-10"></loading>
		</div>
		<div class="balloons custom-scrollbar">
			<div class="balloon no-select" v-for="i in balloons" :key="i.id" :style="generateBalloonStyle(i)" @click="showBalloonContent(i)">
				<i class="fab fa-youtube"></i>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import _ from 'lodash';
import $ from 'jquery';
import Loading from '../../components/Loading.vue';

export default {
	components: {
		Loading,
	},
	props: [
		'question'
	],
	data(){
		return {
			loading: false,
			balloons: [],
		}
	},
	created(){
		this.refreshBalloons();
	},
	methods: {
		generateBalloonStyle(i){
			let red = _.random(0, 255);
			let green = _.random(0, 255);
			let blue = _.random(0, 255);

			let width = _.random(70, 140);

			return `
				background: rgba(${red}, ${green}, ${blue}, 1);
				border: solid 2px rgb(${red}, ${green}, ${blue});
				width: ${width}px;
				height: ${width}px;
			`;
		},

		...mapActions('ShareAnswerDialog', {
			updateShareAnswerDialogQuestion: 'updateQuestion',
			toggleShareAnswerDialogVisible: 'toggleVisible',
		}),

		...mapActions('BalloonContentDialog', {
			updateBallonContentDialogBalloon: 'updateBalloon',
			toggleBallonContentDialogVisible: 'toggleVisible',
		}),

		showShareAnswerDialog(){
			this.updateShareAnswerDialogQuestion(this.question);
			this.toggleShareAnswerDialogVisible(true);
		},
		showBalloonContent(balloon){
			this.updateBallonContentDialogBalloon(balloon)
			this.toggleBallonContentDialogVisible(true);
		},

		refreshBalloons(){
			var vThis = this;
			$.ajax({
				url: '/api/auth/model/balloon/get-all-for-question',
				method: 'POST',
				data: {
					questionID: this.question.id
				},
				beforeSend(){
					vThis.loading = true;
				},
				success(response){
					setTimeout(() => {
						vThis.balloons = response;
					}, 1000);
				},
				complete(){
					setTimeout(() => {
						vThis.loading = false;
					}, 1000);
				},
				error(){
					alert('There was an error fetching data. Try refreshing the page.');
				}
			});
		},
	},
}
</script>

<style lang="scss">
	
@import "../../../scss/variables";

.vRouterPageComponent-App-balloon-section-container{
	width: 100%;
	.prompts{
		width: 100%;
		max-width: 400px;
		margin: 0 auto;
		// text-align: initial;
		h1{
			font-size: 1.4em;
		}
		p{
			font-size: 1.2em;
		}
	}
	.balloons{
		margin-top: 20px;
		padding: 1em;
		text-align: center;
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
			transition: all .15s;
			&:hover{
				transform: scale(1.1, 1.1);
			}
		}
	}
}
</style>