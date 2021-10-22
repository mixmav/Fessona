<template>
	<div class="vPage-component-balloon-content-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">

		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible">
				<div class="title-bar">
					<p class="mt-20">Written by <span class="text-decor bold primary">Anon</span> on <span class="text-decor bold">{{ balloon.created_at }}</span></p>
					<img class="profile-picture" :src="'https://avatars.dicebear.com/api/bottts/' + balloon.id + '.svg'" alt="Profile picture">
				</div>

				<div class="buttons">
					<button v-ripple class="icon-btn primary" @click="toggleVisible(false)"><i class="fa fa-window-close"></i></button>			
					<button class="icon-btn red" v-ripple><i class="fa fa-share-alt"></i></button>
				</div>
				<hr class="mt-10">
				<div class="letter-view ql-snow">
					<div v-show="!isLoading">
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

	data(){
		return {
			isLoading: false,
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
			// max-height: 350px;
			max-width: 500px;
			margin: 0 auto;
			.title-bar{
				width: 100%;
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 10px;
				img{
					width: 50px;
					border: solid 1px rgba(black, 0.1);
					border-radius: 100%;
					padding: 5px;
					height: 50px;
				}
			}

			.buttons{
				display: flex;

				.icon-btn{
					margin-left: 10px;
					&:nth-child(1){
						margin-left: 0;
					}
				}
			}
				
		}
	}
</style>