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
				<div class="main-heading-and-shit">
					<h1>Crowdsourced balloons 🎈</h1>
					<div class="swiper-pagination"></div>
				</div>
				
				<swiper ref="mySwiper" :options="swiperOptions">
					<swiper-slide v-for="i in ballonSectionQuestions" :key="i.id">
						<balloon-section :question="i"></balloon-section>
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


export default {
	components: {
		BalloonSection,
		Swiper,
		SwiperSlide,
		BalloonContentDialog,
		ShareAnswerDialog,
	},

	data(){
		return {

			swiperOptions: {
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				},
				pagination: {
					el: '.swiper-pagination',
					type: 'bullets',
					clickable: true,
				},
				// Some Swiper option/callback...
			},

			ballonSectionQuestions: [
				{
					id: 0,
					prompt: "Share something that makes you smile!",
				},
				{
					id: 1,
					prompt: "Share something that warms your heart 🥰",
				},
				{
					id: 2,
					prompt: 'Share something creative that inspires you 💡',
				},
			]
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
		...mapActions('Alert', [
			'showAlert'
		]),

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
	mounted(){
		var $window = $('.page-content');
		$window.on('scroll', (event) => {
			if ($window.scrollTop() > 80){
				this.updatePageScrolled(true);
			} else {
				this.updatePageScrolled(false);
			}
		});
		// this.showAlert({
		// 	message: 'Your balloons are ready! Click around to explore 🎈'
		// });
		// this.swiper.slideTo(3, 1000, false);
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
			.main-heading-and-shit{
				h1{
					font-size: 1.6em;
				}
			}
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
