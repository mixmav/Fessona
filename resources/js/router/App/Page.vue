<template>
	<div class="vRouterPage-main-app-page-container">
		
		<div class="main-page-content">
			<div class="top-bar">
				<router-link to="/">Fessona</router-link>
				<button class="btn" v-ripple @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-info-circle"></i>How it works</button>
			</div>

			<transition name="opacity">
				<share-answer-dialog v-show="shareAnswerDialogVisible"></share-answer-dialog>
			</transition>

			<transition name="opacity">
				<balloon-content-dialog v-show="balloonContentDialogVisible"></balloon-content-dialog>
			</transition>

			<div class="page-content custom-scrollbar">
				<div class="swiper-pagination"></div>

				<loading v-show="loading"></loading>

				<swiper ref="mySwiper" :options="swiperOptions">
					<swiper-slide v-for="question in questions" :key="question.id">
						<balloon-section :question="question"></balloon-section>
					</swiper-slide>

					<div class="swiper-button-prev" slot="button-prev"></div>
					<div class="swiper-button-next" slot="button-next"></div>
				</swiper>
			</div>
		</div>
	</div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import $ from 'jquery';
import BalloonContentDialog from './BalloonContentDialog.vue';
import ShareAnswerDialog from './ShareAnswerDialog.vue';
import BalloonSection from './BalloonSection.vue';
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import Loading from '../../components/Loading.vue';

export default {
	components: {
		BalloonSection,
		Swiper,
		SwiperSlide,
		BalloonContentDialog,
		ShareAnswerDialog,
		Loading,
	},

	mounted(){
		var $window = $('.page-content');
		$window.on('scroll', (event) => {
			if ($window.scrollTop() > 80){
				this.updatePageScrolled(true);
			} else {
				this.updatePageScrolled(false);
			}
		});

		//TODO
		// setTimeout(() => {
		// 	this.swiper.slideTo(1, 1000, false);
		// }, 1500);

		setTimeout(() => {
			this.$toast.info("Bookmark this page for easy access 🔖");
		}, 10000)

		let vThis = this;
		$.ajax({
			url: '/api/model/question/get-all',
			method: 'POST',
			beforeSend(){
				vThis.loading = true;
			},
			success(response){
				setTimeout(() => {
					vThis.questions = response;
				}, 1000);
			},
			complete(){
				setTimeout(() => {
					vThis.loading = false;
				}, 1000);
			},
			error(){
				vThis.$toast.error('There was an error fetching data. Try refreshing the page.');
			}
		});
	},

	data(){
		return {
			swiperOptions: {
				threshold: 10,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				},
				pagination: {
					el: '.swiper-pagination',
					type: 'bullets',
					clickable: true,
				},
			},

			questions: [],
			loading: false,
		}
	},

	computed: {
		swiper() {
			return this.$refs.mySwiper.$swiper
		},
		
		...mapState('ShareAnswerDialog', {
			shareAnswerDialogVisible: 'visible',
		}),

		...mapState('BalloonContentDialog', {
			balloonContentDialogVisible: 'visible'
		}),
	},

	methods: {
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),

		...mapActions('BalloonContentDialog', {
			toggleBalloonContentVisible: 'toggleVisible'
		}),

		...mapActions([
			'updatePageScrolled',
		]),
	},
}

</script>

<style lang="scss">
@import "../../../scss/variables";

.vRouterPage-main-app-page-container{
	.main-page-content{
		background: transparent;
		animation: backgroundToWhite linear .3s;
		animation-delay: .3s;
		animation-fill-mode: forwards;
		padding: 0 !important;
		
		& > .top-bar{
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			position: fixed;
			top: 0;
			left: 0;
			padding: 1em;
			border-bottom: solid 1px rgba(black, 0.4);

			a{
				text-decoration: none;
				font-size: 2em;
			}
		}

		.page-content{
			padding: 0em {
				top: 30px;
			};
			text-align: center;
			position: fixed;
			top: 78px; //Top bar height
			left: 0;
			width: 100%;
			height: calc(100% - 70px);
			overflow: auto;
			.swiper-wrapper{
				margin-top: 20px;
			}
			.swiper-button-next{
				right: 20px;
				position: fixed;
			}
			.swiper-button-prev{
				left: 20px;
				position: fixed;
			}
			.swiper-pagination{
				position: relative;
				margin-top: 10px;
				// text-align: initial;
				.swiper-pagination-bullet{
					margin-left: 10px;
					&:first-child{
						margin-left: 0;
					}

					&.swiper-pagination-bullet-active{
						background: $primary-color;
					}
				}
			}
		}
	}
}
@keyframes backgroundToWhite {
	to{
		background: rgba(white, 0.7);
	}
}
</style>
