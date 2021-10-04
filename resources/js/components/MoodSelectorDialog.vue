<template>
	<div class="vPage-component-mood-selector-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible">
				<h1>How are you feeling right now?</h1>
				<div class="mood-selector">
					<div class="mood no-select" v-for="mood in moods" :key="mood.id" :class="{selected: mood.selected}" @click="updateSelectedMood(mood.id, $event)">{{ mood.icon }}</div>
				</div>

				<span v-show="!isLoading">
					<button class="btn red mt-30" v-ripple @click="launchApp"><i class="fa fa-play-circle"></i>Enter</button>
					<br>
					<a class="a mt-10" @click="toggleQuickstartDialogVisible(true)">How does it work?</a>
				</span>

				<div v-show="isLoading" class="mt-20">
					<p>Got it. Finding balloons for you!</p>
					<br>
					<loading></loading>
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
			isLoading: false,

			moods: [
				{
					id: 0,
					icon: '😁',
					selected: false,
				},
				{
					id: 1,
					icon: '😊',
					selected: true,
				},
				{
					id: 2,
					icon: '😐',
					selected: false,
				},
				{
					id: 3,
					icon: '😔',
					selected: false,
				},
				{
					id: 4,
					icon: '😭',
					selected: false,
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
	},

	watch: {
		visible(){
			this.updateQuickstartShownOnceOnHomePage(true);
			this.isLoading = false;
		}
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

	.vPage-component-mood-selector-dialog-container{
		z-index: $zIndex-mood-selector-dialog;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		display: flex;
		text-align: initial;
		background: rgba(black, 0.3);
		
		& > .container{
			width: 100%;
			padding: 1em;
			height: 100%;
			max-height: 350px;
			max-width: 500px;
			margin: 50px auto;
			background: white;
			position: relative;
			overflow: auto;
			border-radius: 10px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;

			text-align: center;

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
		}

		& > .bottom-bar{
			top: 380px;
			left: 50%;
			position: fixed;
			transform: translate(-50%, 0px);
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 1em;
			background: $primary-color;
			border-top: solid 2px rgba(black, 0.1);
			width: 100%;
			max-width: 500px;
			border-bottom-left-radius: 10px;
			border-bottom-right-radius: 10px;

			label{
				color: white;
				font-size: .8em;
				font-weight: bold;
			}
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