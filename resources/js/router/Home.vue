<template>
	<div class="vRouterPage-home-page-container">
		<div id="particles-js"></div>
		
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
			<h1 class="mt-50">Active sites</h1>
			<p>Each box below represents a real location at an RMIT Campus where our community leaves goodies for you to find 🥰</p>
			<div class="active-sites">
				<div class="site"></div>
				<div class="site"></div>
			</div>
		</div>
	</div>
</template>

<script>
import 'particles.js/particles';
import { mapActions, mapState } from 'vuex';
import Quickstart from '../components/Quickstart.vue';

export default {
	components: {
		Quickstart,
	},

	mounted(){
		this.particlesJS.load('particles-js', '/assets/particles.json');

		document.querySelector('.main-page-content').addEventListener('mousemove', function(e) { 
			var e = document.createEvent('MouseEvents');
			e.initMouseEvent('mousemove',true,true,document.defaultView, 0, event.screenX, event.screenY, event.clientX, event.clientY,false,false,false,false,null,null);
			document.getElementById("particles-js").childNodes[0].dispatchEvent(e) 
		});

		setTimeout(() => {
			this.showQuickstart();
		}, 2000)
	},
	data(){
		return {
			particlesJS: window.particlesJS,
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
	#particles-js{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 0;
	}
	.main-page-content{
		margin-top: 30px;
		width: 100%;
		max-width: 500px;
		text-align: left;
		display: inline-block;

		.active-sites{
			margin-top: 30px;
			display: flex;
			justify-content: space-between;
			// background: blue;
			.site{
				width: 50%;
				height: 100px;
				display: inline-block;
				// background: red;
			}
		}
	}
}
</style>