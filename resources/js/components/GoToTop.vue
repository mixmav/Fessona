<template>
	<div class="vGo-to-top-container no-select">
		<transition name="transform-scale-full">
			<div class="icon" v-ripple @click="scrollToTop" v-show="pageScrolled">
				<i class="fa fa-caret-up"></i>
			</div>
		</transition>
	</div>
</template>

<script>
import $ from 'jquery';
import { mapState } from 'vuex';

export default {	
	methods: {
		scrollToTop(){
			var body = $(".page-content");
			body.stop().animate({scrollTop:0}, 500, 'swing');
		}
	},

	computed: {
		...mapState([
			'pageScrolled',
		])
	}
}

</script>

<style lang="scss">
	@import "../../scss/variables";

	.vGo-to-top-container{
		position: fixed;
		bottom: 20px;
		right: 20px;
		z-index: $zIndex-go-to-top;
		cursor: pointer;
		.icon{
			width: 45px;
			height: 45px;
			display: flex;
			justify-content: center;
			align-items: center;
			border-radius: 20px;
			background: lighten($darkBlack, 20%);
			i{
				color: white;
			}
		}
	}
</style>