<template>
	<div class="vPage-component-balloon-content-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible">
				<div class="top-bar">
					<button class="btn red" v-ripple @click="toggleVisible(false)"><i class="fa fa-window-close"></i>Close</button>
				</div>

				<section style="text-align: left">
					<div class="author-bar">
						<img src="https://avatars.dicebear.com/api/bottts/hahahah.svg">
						<p>Written by <span>Emma</span></p>
					</div>
					<div style="text-align: center">
						<youtube :player-width="300" :player-height="150" :video-id="videoID"></youtube>
					</div>
				</section>
			</section>
		</transition>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

import $ from 'jquery';

export default {
	components: {
	},

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

	data(){
		return {
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

		...mapActions('BalloonContentDialog', {
			toggleVisible: 'toggleVisible',
		}),
	},

	computed: {
		...mapState('BalloonContentDialog', [
			'visible',
		]),

		videoID(){
			return this.$youtube.getIdFromURL("https://www.youtube.com/watch?v=uLhQxaFn_yE&ab_channel=GoogleAustralia");
		}
	},
}
</script>

<style lang="scss">
	@import "../../../scss/variables";

	.vPage-component-balloon-content-dialog-container{
		z-index: $zIndex-share-answer-dialog;
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
			text-align: center;

			& > .top-bar{
				display: flex;
				justify-content: flex-end;
			}

			section{
				.author-bar{
					width: 100%;
					display: flex;
					justify-content: space-between;
					align-items: center;
					margin-top: 20px;
					margin-bottom: 10px;
					p{
						span{
							font-weight: bold;
							color: $primary-color;
						}
					}
					img{
						width: 50px;
						border: solid 1px rgba(black, 0.1);
						border-radius: 100%;
						padding: 5px;
						height: 50px;
					}
				}
				
			}
		}
	}

	@include media-y(670px){
		.vPage-component-balloon-content-dialog-container{
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