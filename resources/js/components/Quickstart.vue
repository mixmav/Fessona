<template>
	<div class="vPage-component-view-letter-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">
		
		<transition name="translate-y-minus-100px" delay="300">
			<div class="container" v-show="visible" ref="scrollContainer">
				<div class="letter-view ql-snow">
					<div class="top-bar" :class="{'z-depth-1': scrolled}">
						<button v-ripple class="btn green full-width jumbo" @click="toggleVisible({visibility: false})"><i class="fa fa-window-close"></i>Close dialog</button>
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
			</div>
		</transition>

	</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import $ from 'jquery';

export default {
	created(){
		$(window).on({
			keydown: (event) => {
				if (this.visible && event.keyCode == 27 && !this.viewLetterCommentsDialogVisible) {
					this.toggleVisible({visibility: false});
				}
			},
		}, this.$refs.container);

		// this.loadLetter();
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
			isLoading: false,
			scrolled: false,
			letter: {},
			user: {},
		}
	},
	computed: {
		...mapState('ViewLetterDialog', [
			'visible',
			'letterID'
		]),

		...mapState('ViewLetterCommentsDialog', {
			'viewLetterCommentsDialogVisible': 'visible',
		}),

		userProfilePictureFilePath(){
			var base_url = '/images/profile_pictures/'

			if (typeof this.letter.user_id == 'undefined') {
				return base_url + 'stock.png';
			} else {
				return base_url + this.letter.user_id + '.jpg';
			}
		}
	},

	watch: {
		visible(newState, oldState) {
			if (newState) {
				setTimeout(() => {
					this.loadLetter()
				}, 300)
			}
		}
	},

	methods: {
		...mapActions('ViewLetterDialog', {
			'toggleVisible': 'updateVisible'
		}),

		...mapActions('ViewLetterCommentsDialog', {
			'toggleViewLetterCommentsVisible': 'updateVisible'
		}),

		...mapActions('Letters', [
			'updateLettersArray',
		]),

		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				this.toggleVisible({visibility: false});
			}
		},

		loadLetter(){
			var vThis = this;
			$.ajax({
				url: '/api/auth/model/letter/get/' + vThis.letterID,
				method: 'POST',
				beforeSend(){
					vThis.isLoading = true;
				},
				success(response){				
					vThis.letter = response;

					$.ajax({
						url: '/api/auth/model/user/get/' + vThis.letter.user_id,
						method: 'POST',
						success(response){				
							vThis.user = response;
						},
						complete(){
							vThis.isLoading = false;
						},
						error(){
							alert('There was an error fetching data. Try refreshing the page.');
						}
					});

				},
				error(){
					alert('There was an error fetching data. Try refreshing the page.');
				}
			});
		}
	}
}
</script>

<style lang="scss">
	@import "../../../../scss/variables";

	.vPage-component-view-letter-dialog-container{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		display: flex;
		z-index: $zIndex-view-letter-dialog;
		background: rgba(black, 0.3);
		
		& > .container{
			width: 100%;
			height: 100%;
			max-width: 800px;
			margin: 0 auto;
			background: white;
			position: relative;
			overflow: auto;
			
			.top-bar{
				background: white;
				max-width: 800px;
				position: fixed;
				width: 100%;
				left: 50%;
				top: 0;
				padding: 2em;
				transition: all .2s;
				transform: translateX(-50%);
			}
			
			& > .letter-view{
				padding: 2em;
				margin-top: 120px;
				position: relative;
				width: 100%;
				border-radius: 5px;
				transition: all .3s;
				.loading-icon-container{
					text-align: center;
					i{
						padding: 1em;
						font-size: 2em;
						background: $blue;
						color: white;
						display: inline-block;
						border-radius: 100%;
					}
				}

				.title-bar{
					display: flex;
					justify-content: space-between;
					align-items: center;
					.user-name{
						font-weight: bold;
						color: $green;
					}

					.profile-picture{
						width: 70px;
						height: 70px;
						border-radius: 100%;
					}
				}
			}
		}
	}
</style>