<template>
	<div class="vPage-component-balloon-content-dialog-container generic-dialog-container" ref="container" :class="[{visible: visible}]" @click="checkClickClose">

		<transition name="translate-y-minus-100px" delay="300">
			<section class="container custom-scrollbar" v-show="visible">

				<div v-show="loading">
					<loading></loading>
				</div>

				<div v-show="!loading">
					<div class="title-bar">
						<div class="text">
							<h1 v-if="balloon.question !== undefined"><i class="fa fa-box-open"></i>{{ balloon.question.prompt }}</h1>
							<a @click="toggleVisible(false)" class="mt-10 a">Close</a>
							<p class="timestamp">Answered on <span class="text-decor bold">{{ balloon.created_at }}</span></p>
						</div>
						<img class="profile-picture" :src="'https://avatars.dicebear.com/api/personas/' + balloon.id + '.svg'" alt="Profile picture">
					</div>


					<div class="likes">
						<button class="like-btn" @click="likeToggle(!liked)" :disabled="likeLoading">
							<i v-show="likeLoading" class="fa fa-cog fa-spin"></i>
							<i v-show="!liked && !likeLoading" class="far fa-heart"></i>
							<i v-show="liked && !likeLoading" class="fa fa-heart"></i>
						</button>
						<p>{{ balloon.likes }} like<span v-show="balloon.likes != 1">s</span></p>
					</div>

					<div class="letter-view ql-snow">
						<div>
							<div class="preview ql-editor mt-20" v-html="balloon.content"></div>
						</div>
					</div>
				</div>
			</section>
		</transition>

	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Loading from './Loading.vue';
import $ from 'jquery';

import _ from 'lodash';

export default {
	components: {
		Loading,
	},

	created(){
		$(window).on({
			keydown: (event) => {
				if (this.visible && event.keyCode == 27 && !this.loading) {
					this.toggleVisible(false);
				}
			},
		}, this.$refs.container);

		//TEST
		// setTimeout(() => {
		// 	this.getBalloonData();
		// }, 1000);

		if (this.$cookie.get('likedBalloonIDs') !== null) {
			this.likedBalloonIDs = JSON.parse(this.$cookie.get('likedBalloonIDs'));
		} else {
			this.$cookie.set('likedBalloonIDs', JSON.stringify(this.likedBalloonIDs), Infinity);
		}
	},

	beforeDestroy(){
		$(window).off('keydown', this.$refs.container);
	},

	data(){
		return {
			loading: false,
			balloon: {},
			likedBalloonIDs: [],
			likeLoading: false,
		}
	},

	methods: {
		checkClickClose(event){
			if (event.target == this.$refs.container && this.$refs.container.contains(event.target)) {
				if (!this.loading) {
					this.toggleVisible(false);
				}
			}
		},

		...mapActions('BalloonContentDialog', {
			toggleVisible: 'toggleVisible',
		}),

		getBalloonData(){
			let vThis = this;
			$.ajax({
				url: '/api/model/balloon/get-balloon-data',
				method: 'POST',
				data: {
					balloonID: vThis.balloonID
				},
				beforeSend(){
					vThis.loading = true;
				},

				success(response){
					vThis.balloon = response;
				},

				complete(){
					vThis.loading = false;
				},

				error(){
					vThis.$toast.error('There was an error fetching this balloon 🤐');
				}
			});
		},
		
		likeToggle(val){
			if (val) {
				this.likedBalloonIDs = [...this.likedBalloonIDs, this.balloon.id];
				this.$cookie.set('likedBalloonIDs', JSON.stringify(this.likedBalloonIDs), Infinity);
			} else {
				// Remove from likedBalloonIDS
				this.likedBalloonIDs =  _.without(this.likedBalloonIDs, this.balloon.id);
				this.$cookie.set('likedBalloonIDs', JSON.stringify(this.likedBalloonIDs), Infinity);
			}
			this.updateLikeOnServer(val);
		},

		updateLikeOnServer(val){
			let likeStatus = (val) ? "true":"false";
			let vThis = this;
			$.ajax({
				url: '/api/model/balloon/update-like',
				method: 'POST',
				data: {
					balloonID: vThis.balloonID,
					val: likeStatus
				},
				beforeSend(){
					vThis.likeLoading = true;
				},

				success(response){
					vThis.$set(vThis.balloon, 'likes', response);
					vThis.$root.$emit('updateBalloonSectionBalloonLikeCount', {
						balloonID: vThis.balloon.id,
						likeCount: response
					});
				},

				complete(){
					vThis.likeLoading = false;
				},

				error(){
					vThis.$toast.error('There was an error updating your like 🤐');
				}
			});
		}
	},

	computed: {
		...mapState('BalloonContentDialog', [
			'visible',
			'balloonID'
		]),

		liked(){
			if (_.includes(this.likedBalloonIDs, this.balloon.id)) {
				return true;
			} else {
				return false;
			}
		}
	},

	watch: {
		visible(newVal){
			this.getBalloonData();
		},
	}
}
</script>

<style lang="scss">
	@import "../../scss/variables";

	.vPage-component-balloon-content-dialog-container{
		z-index: $zIndex-share-answer-dialog;

		& > .container{
			max-width: 600px;
			margin: 0 auto;
			.title-bar{
				display: flex;
				justify-content: space-between;
				align-items: flex-end;
				padding-bottom: 10px;
				border-bottom: solid 1px rgba(black, 0.5);
				.text{
					.timestamp{
						font-size: 0.8em;
						color: darken(white, 40%);
					}
				}
				img{
					width: 75px;
					height: 75px;
					border-radius: 100%;
				}
			}

			.likes{
				margin-top: 20px;
				padding-left: 1em;
				padding-right: 1em;
				display: flex;
				justify-content: space-between;
				align-items: flex-end;
				.like-btn{
					border: none;
					border-radius: 100%;
					background: transparent;
					font-size: 1.6em;
					cursor: pointer;
					color: $red;
					transition: all .15s;
					i{
						transition: all .2s;
					}

					&:active{
						transform: scale(0.9, 0.9);
					}

					&:disabled{
						cursor: default;
					}
				}
				p{
					font-size: 1.2em;
				}
			}
				
		}
	}
</style>