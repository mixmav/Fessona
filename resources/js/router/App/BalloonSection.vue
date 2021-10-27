<template>
	<div class="vRouterPageComponent-App-balloon-section-container">
		<div class="prompts">
			<h2># {{question.prompt}}</h2>
			<button class="btn mt-10" v-ripple @click="showShareAnswerDialog"><i class="fa fa-plus"></i>Share your answer</button>
			<br>
			<button class="a mt-10 randomize" @click="randomizeBalloons = !randomizeBalloons"><i class="fa fa-random"></i>
				<span v-show="!randomizeBalloons">Randomize</span>
				<span v-show="randomizeBalloons">Un-randomize</span>
			</button>
		</div>
		
		<div style="text-align: center" v-show="loading" class="mt-30">
			<p>Fetching balloons ⚡</p>
			<loading class="mt-10"></loading>
		</div>

		<transition name="opacity">
			<div v-show="!loading && balloons.length > 0">
				<!-- <p class="mt-20">Crowdsourced balloons 🎈</p> -->
			</div>
		</transition>
		
		<transition name="translate-y-100px-opacity">
			<div class="balloons" v-show="!loading && balloons.length > 0">
				<div class="balloon no-select" v-for="i in sortedBalloons" :key="i.id" :style="generateBalloonStyle(i)" @click="showBalloonContent(i.id)">
					<i class="fa fa-heart"></i>
					<!-- <span>{{ 999 }}</span> -->
					<span>{{ i.likes }}</span>
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
import * as Tone from 'tone'
import Loading from '../../components/Loading.vue';
import randomColor from 'randomcolor';

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
			synth: new Tone.MonoSynth().toDestination(),
			AMinorScale: ["F4", "G4", "A4", "Bb4"],
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
			let bg = randomColor({
				seed: i.id,
			});

			let border = bg;
			let width = _.random(70, 140);
			let animationDelay = _.random(0, 3, true);

			return `
				background: ${bg};
				border: solid 2px ${border};
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
			this.synth.triggerAttackRelease(this.AMinorScale[_.random(0, this.AMinorScale.length - 1)], 0.1);

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
							vThis.$toast.info("Balloons ready 🥳");
						}
					}, 800);
				},
				error(){
					vThis.$toast.error('There was an error fetching data 🤐 Refresh?');
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
	padding: 1em {
		top: 0;
	};
	.prompts{
		width: 100%;
		margin: 0 auto;
		opacity: 0;
		animation: opacityFull .2s linear;
		animation-fill-mode: forwards;

		h2{
			font-size: 1.4em;
		}
	}

	.randomize{
		font-size: .9em;
		&:hover{
			&:after{
				display: none;
			}
		}
	}

	.balloons{
		margin-top: 10px;
		text-align: center;
		.balloon{
			display: inline-flex;
			justify-content: center;
			flex-direction: column;
			align-items: center;
			color: white;
			border-radius: 100%;
			margin-left: 10px;
			margin-top: 10px;
			cursor: pointer;
			padding: relative;
			transition: all .15s;
			i{
				font-size: 1.4em;
				transition: all .3s;
			}
			span{
				font-weight: 400;
				font-size: .8em;
			}

			&:hover{
				animation: pulse 1s linear infinite;
				i{
					transform: scale(0.8, 0.8);
				}
			}

			&:active{
				animation: none;
				transform: scale(0.95, 0.95) !important;
			}
		}
	}
}

@keyframes opacityFull {
	to {
		opacity: 1;
	}
}

@keyframes pulse{
	from {
		transform: scale(1,1);
	} 50% {
		transform: scale(1.08,1.08);
	} to {
		transform: scale(1,1);
	}
}
</style>