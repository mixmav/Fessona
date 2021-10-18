<template>
	<div class="vPage-component-balloon-content-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">

		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible" ref="scrollContainer">
				<div class="letter-view ql-snow">
					<div class="top-bar" :class="{'z-depth-1': scrolled}">
						<button v-ripple class="btn primary full-width" @click="toggleVisible(false)"><i class="fa fa-window-close"></i>Close dialog</button>
					</div>
					
					<div class="loading-icon-container mt-50" v-show="isLoading">
						<i class="fa fa-smoking-ban fa-spin"></i>
					</div>

					<div v-show="!isLoading">
						<div class="title-bar mt-50">
							<p class="mt-20">Written by <span class="text-decor bold primary">Anon</span> on <span class="text-decor bold">{{ balloon.created_at }}</span></p>
							<img class="profile-picture" :src="'https://avatars.dicebear.com/api/bottts/' + balloon.id + '.svg'" alt="Profile picture">
						</div>
						
						<hr class="mt-10">
						<div class="preview ql-editor mt-20" v-html="balloon.content"></div>
					</div>
				</div>
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
			isLoading: false,
			scrolled: false,
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
			'balloon'
		]),
	},
}
</script>

<style lang="scss">
	@import "../../../scss/variables";

	.vPage-component-balloon-content-dialog-container{
		z-index: $zIndex-share-answer-dialog;
		
		& > .container{
			max-height: 350px;
			max-width: 500px;

			.title-bar{
				width: 100%;
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-top: 20px;
				margin-bottom: 10px;
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
</style>