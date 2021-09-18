<template>
	<div class="vPage-component-quickstart-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-100px" delay="300">
			<div class="container" v-show="visible" ref="scrollContainer">
				<h1 class="quickstart-heading-1"><span>#</span> What is Fessona?</h1>
				<p>As part of RMIT creative, Fessona was created to be a safe space.</p>
				<img src="/images/spread_love.svg" class="img" alt="">

				<h1 class="quickstart-heading-2" v-scroll-to="generateVueScrollToConfig('quickstart-heading-2')"><span>#</span> How does it work?</h1>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta, aspernatur placeat dolores, dolorum illum sequi, dolore officia sunt itaque fugit amet repellat obcaecati. Sed nihil odit veritatis eum in.</p>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta, aspernatur placeat dolores, dolorum illum sequi, dolore officia sunt itaque fugit amet repellat obcaecati. Sed nihil odit veritatis eum in.</p>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta, aspernatur placeat dolores, dolorum illum sequi, dolore officia sunt itaque fugit amet repellat obcaecati. Sed nihil odit veritatis eum in.</p>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae soluta, aspernatur placeat dolores, dolorum illum sequi, dolore officia sunt itaque fugit amet repellat obcaecati. Sed nihil odit veritatis eum in.</p>

				<div class="bottom-bar">
					<div>
						<h1>Bottom</h1>
					</div>
				</div>
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

		generateVueScrollToConfig(id){
			return {
				el: '.' + id,
				container: '.container',
			}
		}
	},

	computed: {
		...mapState('QuickstartDialog', [
			'visible'
		]),
	}
}
</script>

<style lang="scss">
	@import "../../../scss/variables";

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
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;


			h1{
				padding-bottom: 5px;
				border-bottom: solid 1px transparent;
				transition: all .1s;
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


			.bottom-bar{
				position: absolute;
				bottom: 0;
				left: 0;
				opacity: 0;
				animation: opacityFull .2s;
				animation-delay: .5s;
				animation-fill-mode: forwards;
				div{
					position: fixed;
					padding: 10px;
					border-top: solid 1px rgba(black, 0.1);
					width: calc(100% - 40px);
					max-width: 500px;
					border-bottom-left-radius: 10px;
					background: white;
					border-bottom-right-radius: 10px;
				}
			}

			&::-webkit-scrollbar{
				width: 10px;
				height: 14px;
			}
			&::-webkit-scrollbar-thumb{
				background: #6610f2;
				border-radius: 13px;
			}

			&::-webkit-scrollbar-track{
				background: #FFFFFF;
				border: 4px solid #FFFFFF;
				border-radius: 13px;
				box-shadow: inset 3px 3px 21px 0px #2f2f2f;
			}
		}
	}

	@keyframes opacityFull {
		from {
			opacity: 0;
		} to {
			opacity: 1;
		}
	}
</style>