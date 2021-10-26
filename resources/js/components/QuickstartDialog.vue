<template>
	<div class="vPage-component-quickstart-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<div class="container custom-scrollbar" v-show="visible">
				<h1>You made it 😇</h1>

				<h2 class="quickstart-heading-1" v-scroll-to="generateVueScrollToConfig('quickstart-heading-1')"><span>#</span> What is this</h2>
				
				<p>Using a simple question-answer format, we collect nuggets of good vibes from our community here at RMIT.</p>
				<br>
				<p>Each answer is stored as a balloon that is guaranteed<sup>1</sup> to bring a smile on your face 🎈</p>
				<p class="mt-10"><sup>1</sup>Anecdotal</p>

				<button class="btn full-width mt-30" v-show="this.$route.name == 'Home'" v-ripple @click="getStarted"><i class="fa fa-fighter-jet"></i>Start exploring</button>
				
				<!-- Center the div only if it's the home page 😏😏 -->
				<div :style="(this.$route.name == 'Home') ? 'text-align: center':''" class="mt-10">
					<button class="a" @click="goToAboutPage">More info</button>
				</div>

			</div>
		</transition>
		
		<transition name="opacity-50percent" delay="100">
			<div class="bottom-bar" v-show="visible">
				<label class="mt-10" aria-label="Don't show again">Don't show again <input style="position: relative; top: 1px" type="checkbox" ref="dontShowOnStartupCheckbox" v-model="dontShowOnStartup"></label>
				<button class="btn light" @click="toggleVisible(false)" v-ripple><i class="fa fa-keyboard"></i>Press ESC to close</button>
			</div>
		</transition>

	</div>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex';
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

	mounted(){
		if (this.$cookie.get('quickstartDontShowOnStartup') !== null) {
			let cookieVal = JSON.parse(this.$cookie.get('quickstartDontShowOnStartup'));
			this.$refs.dontShowOnStartupCheckbox.checked = cookieVal;
			this.$refs.dontShowOnStartupCheckbox.dispatchEvent(new Event('change'));
		}
	},

	watch: {
		dontShowOnStartup(val){
			this.$cookie.delete('quickstartDontShowOnStartup');
			this.$cookie.set('quickstartDontShowOnStartup', val, 7);
		},
		visible(){
			this.updateShownOnceOnHomePage(true);
		}
	},

	methods: {
		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				this.toggleVisible(false);
			}
		},

		...mapActions('QuickstartDialog', [
			'toggleVisible',
			'updateShownOnceOnHomePage',
			
		]),

		...mapActions('MoodSelectorDialog', {
			toggleMoodSelectorDialogVisible: 'toggleVisible',
			
		}),

		...mapMutations('QuickstartDialog', [
			'updateDontShowOnStartup',
		]),

		generateVueScrollToConfig(id){
			return {
				el: '.' + id,
				container: '.container',
			}
		},

		getStarted(){
			this.toggleVisible(false);
			setTimeout(() => {
				this.toggleMoodSelectorDialogVisible(true);
			}, 300);
		},
		goToAboutPage(){
			this.toggleMoodSelectorDialogVisible(false);
			this.$router.push('/about');
		}
	},

	computed: {
		...mapState('QuickstartDialog', [
			'visible',
		]),

		...mapFields('QuickstartDialog', [
			'dontShowOnStartup'
		]),
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

	.vPage-component-quickstart-dialog-container{
		z-index: $zIndex-quickstart-dialog;
		& > .container{
			max-height: 500px;
			max-width: 500px;
			margin: 50px auto;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
			h2{
				padding-bottom: 5px;
				border-bottom: solid 1px transparent;
				transition: all .1s;
				font-size: 1.6em;
				cursor: pointer;
				margin-bottom: 10px;
				margin-top: 20px;
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
			left: 50%;
			position: fixed;
			transform: translate(-50%, 0px);
			display: flex;
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
				font-weight: 600;
			}

			top: 550px;
			justify-content: space-between;
		}
	}

	@include media-y(670px){
		.vPage-component-quickstart-dialog-container{
			& > .container{
					padding-bottom: 80px !important; // To be able to read content, offset the bottom bar's height
			}
			& > .bottom-bar{
				top: initial !important;
				bottom: 0 !important;
				border-radius: 0 !important;
			}
		}
	}
</style>