<template>
	<div class="vPage-component-mood-selector-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}, {maximized: maximized}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<section class="container" v-show="visible">
				<transition name="translate-x-minus-100px-opacity">
					<div class="slidable-page page-1 custom-scrollbar" v-show="page == 1">
						<div style="justify-content: space-between; align-items: center; display: flex;">
							<h1>Let's check-in</h1>
							<button class="btn red" @click="!isLoading && toggleVisible(false)" v-ripple><i class="fa fa-keyboard"></i>Close</button>
						</div>
						<p class="mt-20">Courtesy of being human, we all experience a wide spectrum of emotions.</p>
						<p class="mt-10">Broadly speaking, how do <span class="text-decor bold primary">you</span> feel right now?</p>
						<div class="mood-selector">
							<button class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</button>
						</div>

						<div class="mt-20 current-selected-mood">
							<p>You chose {{currentMood.icon}}</p>
							<p class="desc" :class="'id-' + currentMood.id">{{currentMood.desc}}</p>
						</div>

						<div class="mt-30" style="text-align: center" v-show="!isLoadingPage1">
							<button class="btn" v-ripple @click="nextPage"><i class="fa fa-paw"></i>Next</button>
							<a class="a full-width mt-10" @click="toggleQuickstartDialogVisible(true)">What's going on?</a>
						</div>

						<div style="text-align: center" v-show="isLoadingPage1" class="mt-30">
							<p>Brewing ⚡ vibes...</p>
							<loading class="mt-10"></loading>
						</div>
					</div>
				</transition>

				<transition name="translate-x-100px-opacity">
					<div class="slidable-page page-2 custom-scrollbar" v-show="page == 2">
						<div class="content">
							<h1>{{ currentMood.longDesc.heading }}</h1>
							<p class="mt-10" v-html="currentMood.longDesc.section1"></p>
							<p class="mt-20">{{ currentMood.longDesc.premise }} Each response is stored as a <span class="text-decor red">Fessona Balloon</span>. Let's see what they said!</p>
							<img src="/images/girl_with_balloon.svg" alt="Girl holding a balloon">
							
							<div style="text-align: center" v-show="isLoadingPage2" class="mt-30">
								<p>Summoning <span class="text-decor red">hand-picked</span> balloons for you</p>
								<loading class="mt-10"></loading>
							</div>

							<div v-show="!isLoadingPage2" style="display: flex; justify-content: space-between; align-content: center;" class="mt-10">
								<button class="btn red" v-ripple @click="prevPage"><i class="fa fa-paw"></i>Back</button>
								&nbsp;
								<button class="btn" v-ripple @click="launchApp"><i class="fab fa-fly"></i>Balloooonsss</button>
								<button class="btn" @click="cycleMoodsTest" v-ripple>Cycle mood</button><br><br>
							</div>
						</div>
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
					longDesc: {
						heading: "Sorry to hear you're feeling kind of numb",
						section1: "From personal experience, feeling numb is actually the least <span class='text-decor red'>\"fun\"</span> of the lot.",
						premise: "We asked our community how they navigate this challenging emotion.",
					}
				},
				{
					id: 1,
					icon: '😔',
					selected: false,
					desc: 'Disconnected, sad or isolated',
					longDesc: {
						heading: "Sorry to hear you're feeling bad",
						section1: "It's been a rough year. A gentle reminder that you're <span class='text-decor primary'>far from alone</span> in feeling this way.",
						premise: "We asked our community how they cope with feelings of isolation, disconnection or grief.",
					}
				},
				{
					id: 2,
					icon: '😰',
					selected: true,
					desc: 'Anxious or uneasy',
					longDesc: {
						heading: "Sorry to hear you're feeling anxious",
						section1: "Good ol' <span class='text-decor red'>anxiety</span>. On the one hand it's your body trying to keep you safe, but clealry, the archaic threat-detection system is far from perfect.",
						premise: "We asked our community how they navigate their anxiety.",
					}
				},
				{
					id: 3,
					icon: '😊',
					selected: false,
					desc: 'Pretty good',
					longDesc: {
						heading: "Great to hear you're doing well",
						section1: "How about a <span class='text-decor green'>mindful breath</span> to appreciate the calm 😇",
						premise: "We asked our community what they like investing time in when they're feeling good.",
					}
				},
				{
					id: 4,
					icon: '🥰',
					selected: false,
					desc: 'Excellent',
					longDesc: {
						heading: "Awesome to know you're feeling excellent!",
						section1: "Let's channel some of these <span class='text-decor green'>good emotions</span> towards some creativity!",
						premise: "We asked our community what they like investing time in when they're feeling amazing.",
					}
				},
			],
			newMoodID: 0,
		}
	},

	methods: {
		cycleMoodsTest(){
			this.moods.find((mood) => {
				if (mood.selected) {
					if (mood.id === this.moods.length - 1) {
						this.newMoodID = 0;
					} else {
						this.newMoodID++;
					}
					mood.selected = false;
				}
			});

			this.moods.find((mood) => {
				if (mood.id == this.newMoodID) {
					mood.selected = true;
					return true;
				}
			})
		},

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
			this.synth.triggerAttackRelease(this.AMinorScale[newMoodID], 0.1);
			
			if(this.isLoading || event.target.classList.contains('selected')){
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
				background: rgba(white, 0.9);
			}
		}
		& > .container{
			max-height: 450px;
			max-width: 500px;
			position: relative;
			padding: 0;
			overflow: hidden;
			transition: all .25s ease;

			.slidable-page{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				padding: 1em;
				overflow: auto;
				p{
					font-size: 1em;
				}
				&.page-1{
					.mood-selector{
						display: flex;
						flex-direction: row;
						justify-content: space-between;
						align-items: center;
						margin: 20px auto;
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
							font-weight: bold;
							font-size: .9em;
							&.id-1{
								color: $red;
							}
							&.id-2{
								color: $blue;
							}
							&.id-3{
								color: $purple;
							}
							&.id-4{
								color: $green;
							}
						}
					}
				}
				&.page-2{
					& > .content{
						width: 100%;
						max-width: 500px;
						margin: 0 auto;
						img{
							width: 100%;
							max-width: 200px;
							display: block;
							margin: 30px auto;
						}
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