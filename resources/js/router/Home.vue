<template>
	<div class="vRouterPage-home-page-container">
		
		<transition name="opacity">
			<quickstart ref="homePageQuickstart" v-show="quickstartDialogVisible"></quickstart>
		</transition>

		<div class="main-page-content">
			<h1>Fessona</h1>
			<p style="font-size: 1em">/fə'səunə/</p>
			<p class="mt-10">In Roman mythology, Fessona is the goddess that rids people of fatigue.</p>
			
			<button class="btn indigo mt-20" v-ripple v-tooltip.left="'Quickstart'" @click="showQuickstart"><i class="fa fa-info-circle"></i>How it works</button>
			
			&nbsp;
			<button class="btn darkBlack mt-20" v-ripple v-tooltip.right="'Scan a QR code'"><i class="fa fa-qrcode"></i>Scan a QR code</button>
			
			<h1 class="mt-40">Active sites</h1>
			<p>A fessona "site" is a real location at an RMIT Campus where our community leaves goodies for you to find! 🥰</p>
			<router-link tag="button" class="btn full-width red mt-20" to="/browse-sites"><i class="fa fa-scroll"></i>Browse active sites</router-link>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import Quickstart from '../components/Quickstart.vue';


export default {
	components: {
		Quickstart,
	},

	mounted(){
		setTimeout(() => {
			// this.showQuickstart();
		}, 2000)
	},
	data(){
		return {
		}
	},
	
	methods: {
		showQuickstart(){
			this.toggleQuickstartDialogVisible(true);
		},
		
		...mapActions('Alert', [
			'showAlert',
		]),
		
		...mapActions('QuickstartDialog', {
			toggleQuickstartDialogVisible: 'toggleVisible',
		}),
	},
	computed: {
		...mapState('QuickstartDialog', {
			quickstartDialogVisible: 'visible'
		})
	}
}

</script>

<style lang="scss">

@import "../../scss/variables";

.vRouterPage-home-page-container{
	text-align: center;
	.main-page-content{
		margin-top: 60px;
		width: 100%;
		max-width: 500px;
		text-align: left;
		display: inline-block;

		.active-sites{
			margin-top: 30px;
			// text-align: center;
			.site{
				width: 100%;
				border-radius: 10px;
				height: 100px;
				margin-left: 10px;
				cursor: pointer;
				background: $burgandy;
				&:nth-child(even){
					background: $blue;
				}
			}
		}
	}
}
</style>