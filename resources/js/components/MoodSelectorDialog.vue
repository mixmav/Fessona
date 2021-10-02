<template>
	<div class="vPage-component-mood-selector-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-100px" delay="300">
			<div class="container custom-scrollbar" v-show="visible">
				<h1><span>#</span> Mood selector</h1>
				<p>As part of RMIT creative, Fessona was created to be a safe space.</p>

				<h1><span>#</span> How does it work?</h1>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta, aspernatur placeat dolores, dolorum illum sequi, dolore officia sunt itaque fugit amet repellat obcaecati. Sed nihil odit veritatis eum in.</p>

				<button class="btn red mt-20" v-ripple><i class="fa fa-play-circle"></i>Launch</button>
			</div>
		</transition>
		
		<transition name="opacity-50percent" delay="100">
			<div class="bottom-bar" v-show="visible">
				<button class="btn light" @click="toggleVisible(false)" v-ripple><i class="fa fa-keyboard"></i>Press ESC to close</button>
			</div>
		</transition>

	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';
import $ from 'jquery';

export default {
	created(){
		$(window).on({
			keydown: (event) => {
				if (this.visible && event.keyCode == 27) {
					this.toggleVisible(false);
				}
			},
		}, this.$refs.container);
	},

	beforeDestroy(){
		$(window).off('keydown', this.$refs.container);
	},

	watch: {
		dontShowOnStartup(val){
			this.$cookie.delete('quickstartDontShowOnStartup');
			this.$cookie.set('quickstartDontShowOnStartup', val, 7);
		}
	},

	methods: {
		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				this.toggleVisible(false);
			}
		},

		...mapActions('MoodSelectorDialog', [
			'toggleVisible',
		]),

		...mapActions('QuickstartDialog', {
			'updateQuickstartShownOnceOnHomePage': 'updateShownOnceOnHomePage',
		}),

		// launchApp(){
		// 	this.toggleVisible(false);
		// 	setTimeout(() => {
		// 		this.$router.push('/app');
		// 	}, 300);
		// }
	},

	computed: {
		...mapState('MoodSelectorDialog', [
			'visible',
		]),
	},
	watch: {
		visible(){
			this.updateQuickstartShownOnceOnHomePage(true);
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
			max-height: 550px;
			max-width: 500px;
			margin: 30px auto;
			background: white;
			position: relative;
			overflow: auto;
			border-radius: 10px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;


			h1{
				padding-bottom: 5px;
				border-bottom: solid 1px transparent;
				transition: all .1s;
				font-size: 1.6em;
				cursor: pointer;
				margin-bottom: 10px;
				margin-top: 30px;
				&:hover{
					border-color: $primary-color;
				}
				span{
					color: $primary-color;
				}
				&:first-child{
					margin-top: 0;
				}
			}

			.img{
				width: 100%;
				max-width: 150px;
				display: block;
				margin: 10px auto;
			}
		}

		& > .bottom-bar{
			top: 580px;
			left: 50%;
			position: fixed;
			transform: translate(-50%, 0px);
			display: flex;
			justify-content: space-between;
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