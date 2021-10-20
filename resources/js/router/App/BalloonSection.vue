<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<div class="prompts">
			<h1><i class="far fa-bookmark"></i>We asked</h1>
			<p class="text-decor primary">{{question.prompt}}</p>

			<div class="badges">
				<p>Might contain</p>
				<div class="badge" v-for="(badge, key) in question.badges" :key="key">{{ badge }}</div>
			</div>

			<button class="btn mt-10" v-ripple @click="showShareAnswerDialog"><i class="fa fa-plus"></i>Share your answer</button>
		</div>
		
		<div style="text-align: center" v-show="loading" class="mt-30">
			<p>Fetching balloons ⚡</p>
			<loading class="mt-10"></loading>
		</div>
		
		<h3 class="mt-30" v-show="!loading && balloons.length === 0">Oh so empty 😶</h3>

		<div class="balloons custom-scrollbar">
			<div class="balloon no-select" v-for="i in balloons" :key="i.id" :style="generateBalloonStyle(i)" @click="showBalloonContent(i)">
				<i class="fab fa-youtube"></i>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from 'vuex';
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

		...mapActions('Alert', [
			'showAlert'
		]),

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
				url: '/api/model/balloon/get-all-for-question',
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
						if (process.env.NODE_ENV === 'production') {
							vThis.showAlert({
								message: 'Your balloons are ready! Click around to explore 🎈'
							});
						}
					}, 1000);
				},
				complete(){
					setTimeout(() => {
						vThis.loading = false;
					}, 1000);
				},
				error(){
					vThis.showAlert({
						message: 'There was an error fetching data. Try refreshing the page.'
					});
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

		.badges{
			margin: 10px;
			// text-align: left;
			p{
				font-size: .8em;
				margin-bottom: 5px;
			}
			.badge{
				display: inline-block;
				margin-left: 3px;
				padding: 10px {
					top: 5px;
					bottom: 5px;
				};
				border-radius: 10px;
				background: darken(white, 5%);
				border: solid 1px darken(white, 10%);
				transition: all .2s;
				cursor: default;
				&:hover{
					background: $primary-color;
					color: white;
				}
			}
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