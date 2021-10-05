<template>
	<div class="vPage-component-mood-selector-dialog-container generic-dialog-container has-bottom-bar" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible">
				<h1>Quick check-in</h1>
				<p class="mt-10">How're you feeling right now?</p>
				<div class="mood-selector">
					<div class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</div>
				</div>

				<div class="mt-20 current-selected-mood">
					<p>You chose {{currentMood.icon}}</p>
					<p class="desc" :class="currentMood.icon">{{currentMood.desc}}</p>
				</div>

				<div class="mt-30" style="text-align: center" v-show="!isLoading">
					<button class="btn" v-ripple @click="launchApp"><i class="fa fa-basketball-ball"></i>Next</button>
					<a class="a full-width mt-10" @click="toggleQuickstartDialogVisible(true)">How does it work?</a>
				</div>

				<div style="text-align: center" v-show="isLoading" class="mt-30">
					<p>Summoning <span class="text-color red">hand-picked</span> balloons for you</p>
					<loading class="mt-10"></loading>
				</div>
			</section>
		</transition>
		
		<transition name="opacity-50percent" delay="100">
			<div class="bottom-bar" v-show="visible">
				<button class="btn light" @click="!isLoading && toggleVisible(false)" v-ripple><i class="fa fa-keyboard"></i>Press ESC to close</button>
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
			AMinorScale: ['A3', 'B3', 'C4', 'D4', 'E4', 'F4', 'G4'],
			isLoading: false,

			moods: [
				{
					id: 0,
					icon: '😁',
					selected: false,
					desc: 'Fantastic'
				},
				{
					id: 1,
					icon: '😊',
					selected: true,
					desc: 'Good'
				},
				{
					id: 2,
					icon: '😐',
					selected: false,
					desc: 'Meh'
				},
				{
					id: 3,
					icon: '😔',
					selected: false,
					desc: 'Not the best'
				},
				{
					id: 4,
					icon: '😭',
					selected: false,
					desc: 'Bad'
				}
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
				this.updateSelectedMoodInStore(newMoodID);
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
			this.isLoading = true;

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
		& > .container{
			max-height: 400px;
			max-width: 500px;

			.mood-selector{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				align-items: center;
				margin-top: 20px;
				.mood{
					padding: 10px;
					border: solid 4px lighten(grey, 40%);
					border-radius: 10px;
					margin-left: 10px;
					cursor: pointer;
					font-size: 1.2em;
					transition: all .2s;

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
					&.😁{
						color: $green;
					}
					&.😊{
						color: $blue;
					}
					&.😔{
						color: $purple;
					}
					&.😭{
						color: $red;
					}
				}
			}
		}

		& > .bottom-bar{
			top: 430px;
			justify-content: center;
		}
	}

	@include media-y(670px){
		.vPage-component-mood-selector-dialog-container{
			& > .container{
				margin-top: 0;
				padding-bottom: 80px; // To be able to read content, offset the bottom bar's height
				max-height: 100%;
				border-radius: 0;
			}

			& > .bottom-bar{
				top: initial;
				bottom: 0;
				border-radius: 0;
			}
		}
	}
</style>