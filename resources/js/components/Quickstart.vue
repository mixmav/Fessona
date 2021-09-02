<template>
	<div class="vPage-component-quickstart-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-100px" delay="300">
			<div class="container" v-show="visible" ref="scrollContainer">
				<h1>Quickstart</h1>
			</div>
		</transition>

	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
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
		$(window).off('scroll', this.$refs.scrollContainer);
	},

	mounted(){
		var $containerRef = $(this.$refs.scrollContainer);
		$containerRef.on('scroll', (event) => {
			if ($containerRef.scrollTop() > 0){
				this.scrolled = true;
			} else {
				this.scrolled = false;
			}
		});

	},

	data(){
		return {
			scrolled: false,
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
		]),
	},

	computed: {
		...mapState('QuickstartDialog', [
			'visible'
		]),
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

	.vPage-component-quickstart-dialog-container{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		display: flex;
		text-align: initial;
		z-index: $zIndex-quickstart-dialog;
		background: rgba(black, 0.3);
		
		& > .container{
			width: calc(100% - 40px);
			padding: 1em;
			height: 100%;
			max-height: 550px;
			max-width: 500px;
			margin: 30px auto;
			background: white;
			position: relative;
			overflow: auto;
			border-radius: 10px;
			
			// .top-bar{
			// 	background: white;
			// 	max-width: 800px;
			// 	position: fixed;
			// 	width: 100%;
			// 	left: 50%;
			// 	top: 0;
			// 	padding: 2em;
			// 	transition: all .2s;
			// 	transform: translateX(-50%);
			// }
		}
	}
</style>