<template>
	<div class="vRouterPage-browse-sites-page-container">
		
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
				<h1>Crowdsourced balloons 🎈</h1>
				<swiper ref="mySwiper" :options="swiperOptions">
					<swiper-slide v-for="i in ballonSections" :key="i.id">
						<balloon-section id="tourSteps-target-1" :question="i.question"></balloon-section>
					</swiper-slide>
					<div class="swiper-button-prev" slot="button-prev"></div>
					<div class="swiper-button-next" slot="button-next"></div>
				</swiper>

				<v-tour name="introductionTour" :steps="tourSteps" :options="{highlight: true}"></v-tour>
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
			tourSteps: [
				{
					target: '#tourSteps-target-1',
					header: {
						title: 'Get Started',
					},
					content: `Discover <strong>Vue Tour</strong>!`,
					// params: {
					// 	highlight: false
					// }
				}
			],

			swiperOptions: {
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				}
				// Some Swiper option/callback...
			},

			ballonSections: [
				{
					id: 0,
					question: "What makes you feel grounded?",
				},
				{
					id: 1,
					question: "What's one YouTube video that never fails to cheer you up?",
				},
				{
					id: 2,
					question: 'What gets your creative juices flowing?',
				},
				{
					id: 3,
					question: "Fav hype anthem",
				},
				{
					id: 4,
					question: "Fav hype anthem",
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
		// this.$tours['introductionTour'].start();

		var $window = $('.page-content');
		$window.on('scroll', (event) => {
			if ($window.scrollTop() > 80){
				this.updatePageScrolled(true);
			} else {
				this.updatePageScrolled(false);
			}
		});

		// this.swiper.slideTo(3, 1000, false);
	},
}

</script>

<style lang="scss">
@import "../../../scss/variables";

.vRouterPage-browse-sites-page-container{
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
			padding: 1em {
				top: 50px;
			};
			position: fixed;
			top: 78px;
			left: 0;
			width: 100%;
			height: calc(100% - 70px);
			overflow: auto;
			text-align: center;
			.swiper-wrapper{
				margin-top: 20px;
			}
		}
	}
	.v-tour__target--highlighted {
		box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
		padding: 10px;
		.v-step__header{
			color: white !important;
		}
		.v-step__content{
			color: white !important;
		}
	}
}
@keyframes backgroundToWhite {
	to{
		background: rgba(white, 0.7);
	}
}
</style>
