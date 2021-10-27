<template>
	<div class="vRouterPage-main-app-page-container">
		
		<div class="main-page-content">
			<div class="top-bar">
				<div class="spacer">
					<router-link to="/" class="no-select">
						<img src="/images/logos/xxhdpi.png" alt="Logo">
						<span>Fessona</span>
					</router-link>

					<button class="a" @click="toggleQuickstartDialogVisible(true)"><i class="fa fa-cookie-bite"></i>How it works</button>
				</div>
			</div>

			<div class="page-content custom-scrollbar">
				<div class="swiper-pagination"></div>

				<loading v-show="loading" class="mt-40"></loading>

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
import { mapActions } from 'vuex';
import $ from 'jquery';
import BalloonSection from './BalloonSection.vue';

import { Swiper, SwiperSlide } from 'vue-awesome-swiper';
import Loading from '../../components/Loading.vue';

export default {
	components: {
		BalloonSection,
		Swiper,
		SwiperSlide,
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

		//Felt annoying
		// setTimeout(() => {
		// 	this.$toast.info("Bookmark for easy access 🔖");
		// }, 17000)

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
				vThis.$toast.error('There was an error fetching data 🤐 Refresh?');
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
	},

	methods: {
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
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
			position: fixed;
			top: 0;
			left: 0;
			height: 60px;
			border-bottom: solid 1px rgba(black, 0.1);

			& > .spacer{
				display: flex;
				padding: 1em;
				justify-content: space-between;
				align-items: center;
				height: 100%;
				width: 100%;
				max-width: 1000px;
				margin: 0 auto;

				a{
					text-decoration: none;
					display: flex;
					justify-content: space-between;
					align-items: center;
					color: $primary-color;
					&:hover, &:focus{
						img{
							transform: rotate(180deg) scale(1.1, 1.1);
						}
					}
					img{
						width: 30px;
						height: 30px;
						border-radius: 100%;
						margin-right: 10px;
						transition: all .35s;
					}
					span{
						font-size: 1.4em;	
					}
				}
			}
		}

		.page-content{
			padding-top: 20px;
			text-align: center;
			position: fixed;
			width: 100%;
			height: calc(100% - 60px); //Top bar height
			top: 60px;
			left: 0;

			overflow: auto;
			// overflow: hidden;
			
			.swiper-wrapper{
				margin-top: 10px;
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

@include media(630px){
	.vRouterPage-main-app-page-container .main-page-content > .top-bar {
		& > .spacer{
			a img{
				display: none;
			}
			button{
				i{
					display: none;
				}
			}
		} 
	}
}
</style>
