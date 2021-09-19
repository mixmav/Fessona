<template>
    <div id="app-container">
		<alert></alert>
        
		<div class="main-content">	
			<div id="particles-js"></div>
			<transition name="opacity">
				<quickstart ref="homePageQuickstart" v-show="quickstartDialogVisible"></quickstart>
			</transition>

			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
    </div>
</template>

<script>
import Alert from './components/Alert.vue';
import 'particles.js/particles';
import Quickstart from './components/Quickstart.vue';
import { mapState } from 'vuex';

export default {
	components: {
		Alert,
		Quickstart,
	},

	mounted(){
		this.particlesJS.load('particles-js', '/assets/particles.json');
		this.addParticlesJSEventListener();
	},

	updated(){
		this.addParticlesJSEventListener();
	},
    data() {
        return {
			particlesJS: window.particlesJS,
		};
    },
	beforeDestroy() {
		document.querySelector('.main-page-content').removeEventListener('mousemove')
	},
	methods: {
		addParticlesJSEventListener(){
			// Wait for the child node to be rendered by giving it a timeout of 600ms
			// Then pass all mousemove events to the particles div
			setTimeout(() => {
				document.querySelector('.main-page-content').addEventListener('mousemove', e => { 
					var e = document.createEvent('MouseEvents');
					e.initMouseEvent('mousemove',true,true,document.defaultView, 0, event.screenX, event.screenY, event.clientX, event.clientY,false,false,false,false,null,null);
					document.getElementById("particles-js").childNodes[0].dispatchEvent(e) 
				});
			}, 600);
		}
	},

	computed: {
		...mapState('QuickstartDialog', {
			quickstartDialogVisible: 'visible',
		}),

	}
};
</script>

<style lang="scss">
@import "../scss/variables";


#app-container {
    & > .main-content {
		#particles-js{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 0;
		}
		.main-page-content{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			width: 100%;
			text-align: left;
        	padding: 1em;
			z-index: $zIndex-router-content;
		}
    }
}
</style>