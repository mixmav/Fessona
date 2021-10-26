<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<div class="prompts">
			<h2 style="text-align: left"><i class="fa fa-flask"></i>{{question.prompt}}</h2>
			<button class="btn mt-10 full-width" v-ripple @click="showShareAnswerDialog"><i class="fa fa-plus"></i>Share your answer</button>
		</div>
		
		<div style="text-align: center" v-show="loading" class="mt-30">
			<p>Fetching balloons ⚡</p>
			<loading class="mt-10"></loading>
		</div>

		<transition name="opacity">
			<div v-show="!loading && balloons.length > 0">
				<h3 class="mt-20">Crowdsourced balloons 🎈</h3>
				<button class="btn yellow mt-10" @click="randomizeBalloons = !randomizeBalloons" v-ripple><i class="fa fa-dice"></i>Randomize</button>
			</div>
		</transition>
		
		<transition name="translate-y-100px-opacity">
			<div class="balloons custom-scrollbar" v-show="!loading && balloons.length > 0">
				<div class="balloon no-select" v-for="i in sortedBalloons" :key="i.id" :style="generateBalloonStyle(i)" @click="showBalloonContent(i.id)">
					<i class="fa fa-heart"></i>&nbsp;{{ i.likes }}
				</div>
			</div>
		</transition>

		<p class="mt-30" v-show="!loading && balloons.length === 0">Oh so empty 😶</p>
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
		'question',
	],
	data(){
		return {
			loading: false,
			balloons: [],
			randomizeBalloons: false,
		}
	},
	created(){
		this.refreshBalloons();
	},
	mounted(){
		this.$root.$on('updateBalloonSectionBalloonLikeCount', data => {
			let index = _.findIndex(this.balloons, ['id', data.balloonID]);
			if (index >= 0) {
				this.balloons[index].likes = data.likeCount;
			}
		});
	},
	computed: {
		sortedBalloons(){
			if (this.randomizeBalloons) {
				return _.shuffle(this.balloons);
			} else {
				return this.balloons;
			}
		}
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
			updateBallonContentDialogBalloonID: 'updateBalloonID',
			toggleBallonContentDialogVisible: 'toggleVisible',
		}),

		showShareAnswerDialog(){
			this.updateShareAnswerDialogQuestion(this.question);
			this.toggleShareAnswerDialogVisible(true);
		},

		showBalloonContent(id){
			this.updateBallonContentDialogBalloonID(id)
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
					vThis.balloons = response;
				},
				complete(){
					setTimeout(() => {
						vThis.loading = false;
						if (vThis.question.id == 1) { // only trigger toastification on balloonready on the first one
							vThis.$toast.success("Balloons ready 🥳");
						}
					}, 800);
				},
				error(){
					vThis.$toast.error('There was an error fetching data. Try refreshing the page.');
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
	padding: 1em;

	.prompts{
		width: 100%;
		max-width: 500px;
		margin: 0 auto;
		opacity: 0;
		animation: opacityFull .2s linear;
		animation-fill-mode: forwards;

		h2{
			font-size: 1.4em;
		}
	}

	.balloons{
		margin-top: 10px;
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

			&:active{	
				transform: scale(0.95, 0.95);
			}
		}
	}
}

@keyframes opacityFull {
	to {
		opacity: 1;
	}
}
</style>