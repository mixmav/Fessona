<template>
	<div class="vPage-component-balloon-content-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		<transition name="translate-y-minus-100px" delay="300">
			
			<section class="container" v-show="visible" ref="scrollContainer">
				<div class="letter-view ql-snow">
					<div class="top-bar" :class="{'z-depth-1': scrolled}">
						<button v-ripple class="btn green full-width jumbo" @click="toggleVisible(false)"><i class="fa fa-window-close"></i>Close dialog</button>
						<button :disabled="isLoading" v-ripple class="btn blue full-width jumbo mt-10" @click="toggleViewLetterCommentsVisible(true)"><i class="fa fa-comments"></i>Comments</button>
					</div>
					
					<div class="loading-icon-container mt-50" v-show="isLoading">
						<i class="fa fa-smoking-ban fa-spin"></i>
					</div>

					<div v-show="!isLoading">
						<div class="title-bar mt-50">
							<div>
								<h1>{{ letter.title }}</h1>
								<p class="mt-20">Written by <span class="user-name">{{ user.name }}</span> on {{ letter.created_at }}</p>
							</div>

							<img class="profile-picture" :src="userProfilePictureFilePath" alt="Profile picture">
						</div>
						
						<hr class="mt-10">
						<div class="preview ql-editor mt-20" v-html="letter.content"></div>
					</div>
				</div>
			</section>

		</transition>
	</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';

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
			letter: {},
			user: {},
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
		
		& > .container{
			max-height: 350px;
			max-width: 500px;
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
</style>