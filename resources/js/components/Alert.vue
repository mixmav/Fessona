<template>
	<div class="vWindow-alert-component-container" ref="container" :class="{visible: visible}" @click="checkClickClose">
		<div class="window-alert-box z-depth-3">
			<div class="content">
				<p v-html="message"></p>
			</div>

			<button class="btn full-width fixed-bottom" @click="toggleVisible(false)"><i class="fa fa-keyboard"></i>Press any key to close</button>
		</div>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import $ from 'jquery';

export default{
	created(){
		$(window).on({
			keydown: () => {
				if (this.visible) {
					this.toggleVisible(false);
				}
			},
		}, this.$refs.container);
	},

	beforeDestroy(){
		$(window).off('keydown', this.$refs.container);
	},

	data(){
		return{
		}
	},

	computed: {
		...mapState('Alert', [
			'visible',
			'message',
		]),
	},

	methods: {
		...mapActions('Alert', {
			'toggleVisible': 'updateVisible'
		}),

		checkClickClose(){
			if(this.$refs.container == event.target){
				this.toggleVisible(false);
			}
		}
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

.vWindow-alert-component-container{
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(black, 0.3);
	z-index: -1000;
	opacity: 0;
	transition: all 0s .1s;
	.window-alert-box{
		width: 80%;
		max-width: 300px;
		min-height: 220px;
		max-height: 350px;
		overflow: auto;
		background: white;
		position: relative;
		text-align: center;
		top: 50%;
		left: 50%;
		padding: 1em {
			top: 1.5em;
		}
		border-radius: 5px;

		transform: translate(-50%, 0);
		opacity: 0;
		transition: all .15s ease-in;

		.content{
			p{
				color: rgba(black, 0.7);
				font: {
					size: 1.1em;
					weight: 700;
				}

				i{
					color: inherit;
					position: relative;
					margin-right: 5px;
					&.error{
						color: $red;
						bottom: 2px;
					}

					&.blue{
						color: $blue;
					}
				}
			}
		}

		button.fixed-bottom{
			position: absolute;
			bottom: 1em;
			left: 1em;
			padding: {
				top: 1em;
				bottom: 1em;
			}
			width: calc(100% - 2em);
		}
	}
	&.visible{
		z-index: $zIndex-window-alert;
		opacity: 1;
		transition: none;
		.window-alert-box{
			opacity: 1;
			transform: translate(-50%, -50%);
			transition: all .15s ease-out .1s;
		}
	}
}
</style>
