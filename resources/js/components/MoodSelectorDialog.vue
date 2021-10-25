<template>
	<div class="vPage-component-mood-selector-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}, {maximized: maximized}]" @click="checkClickClose">

		<transition name="translate-y-minus-100px" delay="300">
			<div class="container custom-scrollbar" v-show="visible">
				<div class="main-dialog-content">
					<div class="top-bar">
						<h1>Check-in</h1>
						<a class="a" @click="!loading && toggleVisible(false)" v-ripple>Close</a>
					</div>
					<h2 class="mt-20">Birth, death, and the silly bit in-between</h2>
					
					<p class="mt-10">Being the balloon connoisseurs we are, we have something for everyone. Is there anything in particular you'd like to explore first?</p>
				
					<div class="mood-selector">
						<button class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</button>
					</div>

					<div class="mt-20 current-selected-mood">
						<!-- <p>You chose {{currentMood.icon}}</p> -->
						<p class="desc">{{currentMood.desc}}</p>
					</div>

					<div class="mt-10" style="text-align: center" v-show="!loading">
						<button class="btn full-width" v-ripple @click="launchApp"><i class="fa fa-cheese"></i>Next</button>
						<p class="hint mt-10">Unsure? just click next.</p>
						<a class="a mt-10" @click="toggleQuickstartDialogVisible(true)">What's going on?</a>
					</div>

					<div style="text-align: center" v-show="loading" class="mt-30">
						<p>Summoning balloons 4 u 👉👈</p>
						<loading class="mt-10"></loading>
					</div>
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
			AMinorScale: ["F4", "G4", "A4", "Bb4"],
			loading: false,
			maximized: false,
			moods: [
				{
					id: 1,
					icon: '💡',
					selected: false,
					desc: 'Creative inspiration 🎨',
				},
				{
					id: 2,
					icon: '🧘‍♀️',
					selected: true,
					desc: 'Calmness, being grounded',
				},
				{
					id: 3,
					icon: '❤️',
					selected: false,
					desc: 'LOLs and uplifting vibes',
				},
				{
					id: 4,
					icon: '🎵',
					selected: false,
					desc: 'Good tunes',
				},
			],
		}
	},

	methods: {
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
			this.synth.triggerAttackRelease(this.AMinorScale[newMoodID - 1], 0.1);
			
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

		launchApp(){
			this.loading = true;
			setTimeout(() => {
				this.maximized = true;
				setTimeout(() => {
					this.toggleVisible(false);
					setTimeout(() => {
						this.$router.push('/app');
					}, 300);
				}, 5000)
			}, 500)
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
			max-height: 510px;
			max-width: 550px;
			transition: all .35s ease;
			& > .main-dialog-content{
				width: 100%;
				max-width: 500px;
				margin: 0 auto;
				& > .top-bar{
					justify-content: space-between;
					align-items: center;
					display: flex;
				}
				p.hint{
					font-size: .8em;
					text-align: center;
					color: darken(white, 35%);
				}
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
							border-radius: 100%;
							cursor: default;
							padding-left: 12px;
							padding-right: 12px;
							border-color: $primary-color;
						}
					}
				}
				.current-selected-mood{
					text-align: center;
					.desc{
						font-weight: 600;
						font-size: .9em;
						color: $primary-color;
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