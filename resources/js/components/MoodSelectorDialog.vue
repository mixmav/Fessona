<template>
	<div class="vPage-component-mood-selector-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}, {maximized: maximized}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<section class="container" v-show="visible">
				<transition name="translate-x-minus-100px-opacity">
					<div class="slidable-page custom-scrollbar" v-show="page == 1">
						<div style="justify-content: space-between; align-items: center; display: flex;">
							<h1>Quick check-in</h1>
							<button class="btn red" @click="!isLoading && toggleVisible(false)" v-ripple><i class="fa fa-keyboard"></i>Close</button>
						</div>
						<p class="mt-10">How're you feeling right now?</p>
						<div class="mood-selector">
							<div class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</div>
						</div>

						<div class="mt-20 current-selected-mood">
							<p>You chose {{currentMood.icon}}</p>
							<p class="desc" :class="'id-' + currentMood.id">{{currentMood.desc}}</p>
						</div>

						<div class="mt-30" style="text-align: center" v-show="!isLoadingPage1">
							<button class="btn full-width" v-ripple @click="nextPage"><i class="fa fa-paw"></i>Next</button>
							<a class="a full-width mt-10" @click="toggleQuickstartDialogVisible(true)">How does it work?</a>
						</div>

						<div style="text-align: center" v-show="isLoadingPage1" class="mt-30">
							<p>Working things out...</p>
							<loading class="mt-10"></loading>
						</div>
					</div>
				</transition>

				<transition name="translate-x-100px-opacity">
					<div class="slidable-page custom-scrollbar" v-show="page == 2">

						<div v-show="!isLoadingPage2">
							<p>{{ currentMood.icon }}</p>
							<p>{{ currentMood.desc }}</p>
							<p>{{ currentMood.longDesc }}</p>
						</div>
						<div style="text-align: center" v-show="isLoadingPage2" class="mt-30">
							<p>Summoning <span class="text-color red">hand-picked</span> balloons for you</p>
							<loading class="mt-10"></loading>
						</div>
						<button class="btn" v-ripple @click="prevPage"><i class="fa fa-paw"></i>Back</button>
						<button class="btn mt-20" v-ripple @click="launchApp"><i class="fab fa-fly"></i>Launch</button>
					</div>
				</transition>
			</section>
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
					if (!this.isLoading) {
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
			isLoadingPage1: false,
			isLoadingPage2: false,
			maximized: true,
			page: 2,
			moods: [
				{
					id: 0,
					icon: '😶',
					selected: false,
					desc: 'Meh, kind of numb',
					longDesc: "Sorry to hear you're feeling bad :("
				},
				{
					id: 1,
					icon: '😭',
					selected: false,
					desc: 'Sad, down or hurt',
					longDesc: "Sorry to hear you're feeling bad :("
				},
				{
					id: 2,
					icon: '😔',
					selected: false,
					desc: 'Lonely, disconnected or isolated',
					longDesc: "Sorry to hear you're feeling bad :("
				},
				{
					id: 3,
					icon: '😰',
					selected: false,
					desc: 'Anxious or uneasy',
					longDesc: "Sorry to hear you're feeling bad :("
				},
				{
					id: 4,
					icon: '👌',
					selected: true,
					desc: 'Nope, I feel pretty good',
					longDesc: "Sorry to hear you're feeling bad :("
				},
			]
		}
	},

	methods: {
		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				if (!this.isLoading) {
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
			if(this.isLoading || event.target.classList.contains('selected')){
				return;
			} else {
				this.synth.triggerAttackRelease(this.AMinorScale[newMoodID], 0.1);
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
		nextPage(){
			this.isLoadingPage1 = true;
			setTimeout(() => {
				this.page = 2;
				setTimeout(() => {
					this.isLoadingPage1 = false;
					this.maximized = true;
				}, 800);
			}, 4000);
		},

		prevPage(){
			this.page = 1;
			setTimeout(() => {
				this.maximized = false;
			}, 400);
		},

		launchApp(){
			this.isLoadingPage2 = true;

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
		isLoading: {
			get(){
				return this.isLoadingPage1 || this.isLoadingPage2;
			},
			set(newVal){
				this.isLoadingPage1 = newVal;
				this.isLoadingPage2 = newVal;
			}
		}
	},

	watch: {
		visible(newVal){
			this.updateQuickstartShownOnceOnHomePage(true);
			if (newVal) {
				this.isLoading = false;
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
				background: rgba(white, 0.8);
			}
		}
		& > .container{
			max-height: 400px;
			max-width: 500px;
			position: relative;
			padding: 0;
			overflow: hidden;
			transition: all .2s;

			.slidable-page{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				padding: 1em;
				overflow: auto;
			}

			.mood-selector{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				align-items: center;
				margin: 20px auto;
				width: 100%;
				max-width: 400px;
				.mood{
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
						transform: scale(1.1, 1.1);
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
					font-weight: bold;
					font-size: .9em;
					&.id-1{
						color: $green;
					}
					&.id-2{
						color: $blue;
					}
					&.id-3{
						color: $purple;
					}
					&.id-4{
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
						font-size: 1em;
					}
				}
			}
		}
	}
</style>