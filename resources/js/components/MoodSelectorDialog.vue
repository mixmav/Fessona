<template>
	<div class="vPage-component-mood-selector-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}, {maximized: maximized}]" @click="checkClickClose">

		<transition name="translate-y-minus-100px" delay="300">
			<div class="container custom-scrollbar" v-show="visible">
				
				<div class="top-bar">
					<h1>Hola</h1>
					<a class="a" @click="!loading && toggleVisible(false)" v-ripple>Close</a>
				</div>
				<h2 class="mt-20">Birth, death, and the silly bit in-between</h2>
				
				<p class="mt-10">In light of how you're feeling right now, what are you most in-need of? If you're not sure, just click next.</p>
			
				<div class="mood-selector">
					<button class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</button>
				</div>

				<div class="mt-20 current-selected-mood">
					<p>You chose {{currentMood.icon}}</p>
					<p class="desc" :class="'id-' + currentMood.id">{{currentMood.desc}}</p>
				</div>

				<div class="mt-30" style="text-align: center" v-show="!loading">
					<button class="btn full-width" v-ripple @click="launchApp"><i class="fa fa-cheese"></i>Next</button>
					<a class="a mt-10" @click="toggleQuickstartDialogVisible(true)">What's going on?</a>
				</div>

				<div style="text-align: center" v-show="loading" class="mt-30">
					<p>Brewing ⚡</p>
					<loading class="mt-10"></loading>
				</div>

			</div>
		</transition>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Loading from '../components/Loading.vue';
import * as Tone from 'tone'
import _ from 'lodash';
import $ from 'jquery';

export default {
	components: {
		Loading,
	},

	created(){
		$(window).on({
			keydown: (event) => {
				if (this.visible && event.keyCode == 27) {
					if (!this.loading) {
						this.toggleVisible(false);
					}
				}
			},
		}, this.$refs.container);
	},

	beforeDestroy(){
		$(window).off('keydown', this.$refs.container);
	},

	data(){
		return {
			synth: new Tone.MonoSynth().toDestination(),
			AMinorScale: ['C4', 'D4', 'E4', 'F4', 'G4'],
			loading: false,
			maximized: false,
			page: 1,
			moods: [
				{
					id: 0,
					icon: '💡',
					selected: false,
					desc: 'Creative inspiration',
					longDesc: {
						heading: "Creativity, you say?",
						section1: "Being in a creative flow-state is one of the most <span class='text-decor red'>fun</span> ways to spend time.",
						premise: "We asked our community what gets their creative juices flowing. Hopefully you can draw inspiration from them.",
					}
				},
				{
					id: 1,
					icon: '🧘‍♀️',
					selected: true,
					desc: 'Calmness, being grounded',
					longDesc: {
						heading: "🧘‍♂️🧘‍♀️",
						section1: "It's been a rough year with so much impeding on our sense of wellbeing.",
						premise: "We asked our community to share their rituals, practices and tips on cultivating a sense of inner-peace.",
					}
				},
				{
					id: 2,
					icon: '❤️',
					selected: false,
					desc: 'Lighthearted and uplifting energy',
					longDesc: {
						heading: "Pick-me-up!",
						section1: "Being in a cheerful and light-hearted state is one of most fundamental aspects of our wellbeing. It colors everything else we experience.",
						premise: "We asked our community to share tit-bits of what cheers them up.",
					}
				},
				// {
				// 	id: 3,
				// 	icon: '😊',
				// 	selected: true,
				// 	desc: 'Pretty good',
				// 	longDesc: {
				// 		heading: "Great to hear you're doing well",
				// 		section1: "How about a <span class='text-decor green'>mindful breath</span> to appreciate the calm 😇",
				// 		premise: "We asked our community what they like investing time in when they're feeling good.",
				// 	}
				// },
				// {
				// 	id: 4,
				// 	icon: '🥰',
				// 	selected: false,
				// 	desc: 'Excellent',
				// 	longDesc: {
				// 		heading: "Awesome to know you're feeling excellent!",
				// 		section1: "Let's channel some of these <span class='text-decor green'>good emotions</span> towards some creativity!",
				// 		premise: "We asked our community what they like investing time in when they're feeling amazing.",
				// 	}
				// },
			],
			// newMoodID: 0,
		}
	},

	methods: {
		// cycleMoodsTest(){
		// 	this.moods.find((mood) => {
		// 		if (mood.selected) {
		// 			if (mood.id === this.moods.length - 1) {
		// 				this.newMoodID = 0;
		// 			} else {
		// 				this.newMoodID++;
		// 			}
		// 			mood.selected = false;
		// 		}
		// 	});

		// 	this.moods.find((mood) => {
		// 		if (mood.id == this.newMoodID) {
		// 			mood.selected = true;
		// 			return true;
		// 		}
		// 	})
		// },

		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				if (!this.loading) {
					this.toggleVisible(false);
				}
			}
		},

		...mapActions('MoodSelectorDialog', {
			toggleVisible: 'toggleVisible',
			updateSelectedMoodInStore: 'updateSelectedMood'
		}),

		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
			updateQuickstartShownOnceOnHomePage: 'updateShownOnceOnHomePage',
		}),

		updateSelectedMood(newMoodID, event){
			this.synth.triggerAttackRelease(this.AMinorScale[newMoodID], 0.1);
			
			if(this.loading || event.target.classList.contains('selected')){
				return;
			} else {
				this.updateSelectedMoodInStore({
					...this.currentMood
				});
				this.moods.find((mood) => {
					if (mood.selected) {
						mood.selected = false;
					}
				});

				this.moods.find((mood) => {
					if (mood.id == newMoodID) {
						mood.selected = true;
						return true;
					}
				})
			}
		},
		// nextPage(){
		// 	this.isLoadingPage1 = true;
		// 	setTimeout(() => {
		// 		this.page = 2;
		// 		setTimeout(() => {
		// 			this.isLoadingPage1 = false;
		// 			this.maximized = true;
		// 		}, 800);
		// 	}, 4000);
		// },

		// prevPage(){
		// 	this.page = 1;
		// 	setTimeout(() => {
		// 		this.maximized = false;
		// 	}, 400);
		// },

		launchApp(){
			this.loading = true;
			this.maximized = true;
			setTimeout(() => {
				this.toggleVisible(false);
				setTimeout(() => {
					this.$router.push('/app');
				}, 300);
			}, 5000)
		}
	},

	computed: {
		...mapState('MoodSelectorDialog', [
			'visible',
		]),

		currentMood(){
			return _.find(this.moods, (o) => {
				return o.selected;
			})
		},
	},

	watch: {
		visible(newVal){
			this.updateQuickstartShownOnceOnHomePage(true);
			if (newVal) {
				this.loading = false;
				this.maximized = false;
			}
		}
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

	.vPage-component-mood-selector-dialog-container{
		z-index: $zIndex-mood-selector-dialog;
		&.maximized{
			& > .container{
				max-width: 100%;
				max-height: 100%;
				margin-top: 0;
				border-radius: 0;
				background: rgba(white, 0.9);
			}
		}
		& > .container{
			max-height: 520px;
			max-width: 500px;
			transition: all .25s ease;
			& > .top-bar{
				justify-content: space-between;
				align-items: center;
				display: flex;
			}
			// p{
			// 	font-size: 1em;
			// }
			.mood-selector{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				align-items: center;
				margin: 30px auto;
				width: 100%;
				max-width: 400px;
				.mood{
					background: transparent;
					padding: 10px;
					border: solid 4px lighten(grey, 40%);
					border-radius: 10px;
					margin-left: 10px;
					cursor: pointer;
					font-size: 1.2em;
					transition: all .2s;
					&:nth-child(1){
						margin-left: 0;
					}
					&:hover, &:focus{
						outline: 0;
						border-color: lighten($primary-color, 40%);
					}

					&.selected{
						background: lighten(blue, 45%);
						transform: scale(1.1, 1.1);
						cursor: default;
						border-color: $primary-color;
					}
				}
			}
			.current-selected-mood{
				text-align: center;
				.desc{
					font-weight: 600;
					font-size: .9em;
					&.id-0{
						color: $blue;
					}
					&.id-1{
						color: $green;
					}
					&.id-2{
						color: $red;
					}
				}
			}
		}
	}

	@include media-y(670px){
		.vPage-component-mood-selector-dialog-container{
			& > .container{
				margin-top: 0;
				max-height: 100%;
				border-radius: 0;
			}
		}
	}
	@include media(370px){
		.vPage-component-mood-selector-dialog-container{
			& > .container{
				.mood-selector{
					.mood{
						font-size: 1em !important;
					}
				}
			}
		}
	}
</style>